<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Admin\DocusignController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Mail;
use Session;
use App\Mail\DomainReviewTerm;
use App\Mail\CounterLeaseVendor;
use App\Mail\UserSetTermPriceDrop;
use App\Models\CounterOffer;
use App\Models\Domain;
use App\Models\Contract;
use App\Models\User;
use App\Traits\DocusignTrait;
use App\Http\Controllers\Front\ReviewController;
use App\Traits\DomainBuyerTrait;

class CounterOfferController extends Controller
{   
    use DocusignTrait,DomainBuyerTrait;
    
    /**
     * This function is used for counter offer
     * POST counter/{domain} 
     * @param $request
     * @param $domain
     *   
     */ 
    public function counterOffer(Request $request, $domainName)
    {   
        $domainDetail = Domain::getDetailUsingDomainName($domainName);
        $contracts = Contract::where('domain_id',$domainDetail->id)->first();
        $isVendor = Auth::user()->is_vendor;
        
        $this->convertLessorToLessee($domainName);
         //check for domain 
         if(Auth::user()->is_vendor == 'yes') {
            $counterOffer = CounterOffer::where(['domain_name' => $domainName, 'lessor_id' => Auth::user()->id])->exists();
            $domainCheckForUser = Domain::where(['user_id' => Auth::user()->id, 'domain' => $domainName])->first();
            if(empty($domainCheckForUser) && !$counterOffer) {
                abort('403', 'Not accessible');
            }
        } else if(Auth::user()->is_vendor == 'no' || Auth::user()->is_vendor == 'pending') {
            $isVendor = 'no';
            $counterOffer = CounterOffer::where(['domain_name' => $domainName, 'lessee_id' => Auth::user()->id])->exists();
            if(!$counterOffer) {
                abort('403', 'Not accessible');
            }
        }

        $counterOffer = [];
        if (Auth::user()->is_vendor == 'yes' || (isset(Auth::user()->admin) && Auth::user()->admin == 1)) {
            $lesseeId = CounterOffer::where('domain_name', $domainName)->pluck('lessee_id')->first();
            $name = User::where('id', $lesseeId)->pluck('name')->first();
            $counterOffer = CounterOffer::where(['domain_name' => $domainName, 'lessor_id' => null])->first();
        } else {
            $lessorId = CounterOffer::where('domain_name', $domainName)->pluck('lessor_id')->first();
            $name = User::where('id', $lessorId)->pluck('name')->first();
            $counterOffer = CounterOffer::where(['domain_name' => $domainName, 'lessee_id' => null])->first();
        }        
    
        return view('front.review.counter', compact('contracts', 'domainName', 'name', 'isVendor', 'counterOffer'));
    }

    
    /**
     * send mail to user from vendor in counter lease
     * POST counter/contract 
     * @param $request
     * @param ReviewController
     */
    public function counterContract(Request $request,ReviewController $reviewController,DocusignController $docusign)
    {   
        $validator = \Validator::make($request->all(), [
            'first_payment' => 'required|numeric',
            'period_payment' => 'required|numeric',
            'number_of_periods' => 'required|numeric',
            'option_purchase_price' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $data = $request->except('_token');
        $request->flash();
        $this->convertLessorToLessee($data['domain_name']);

        if (Auth::user()->is_vendor == 'yes') {
            $lesseeId = CounterOffer::where(['domain_name' => $data['domain_name'], 'lessor_id' => null])->first()->lessee_id;
            $toEmail = User::find($lesseeId)->email;
            $data['from_email'] = Auth::user()->email;
        } else {
            $lessorId = CounterOffer::where(['domain_name' => $data['domain_name'], 'lessee_id' => null])->first()->lessor_id;
            $toEmail = User::find($lessorId)->email;
            $data['from_email'] = Auth::user()->email;
        }

        try {

            $isLessorData = [];
            $isLesseeData = [];
            if(Auth::user()->is_vendor == 'yes') {
                $data['lessor_id'] = (string)Auth::user()->id;
                $isLessorData = CounterOffer::where(['domain_name' => $data['domain_name'], 'lessor_id' => $data['lessor_id']])->first();
                $data['lessee_id'] = null;
                

            } else  {
                $data['lessee_id'] = (string)Auth::user()->id;
                $isLesseeData = CounterOffer::where(['domain_name' => $data['domain_name'], 'lessee_id' => $data['lessee_id']])->first();
                $data['lessor_id'] = null;
            }

            
            if (Auth::user()->is_vendor == 'yes') {
                Session::put('email', $toEmail);
                Session::put('data',$data);
            } else {
                Mail::to($toEmail)->later(now()->addMinutes(1), new DomainReviewTerm($data));
            }
            unset($data['from_email']);

            $contractId = CounterOffer::where('domain_name', $data['domain_name'])->pluck('contract_id')->first();
            
            $diff_in_hours = docusignHourDifference();

            if ($diff_in_hours > 7) {
                $docusign->refreshToken();
            }

            //update lessor data
            if(is_null($data['lessee_id'])) {
                if(!empty($isLessorData)) {
                    $isLessorData = CounterOffer::where(['domain_name' => $data['domain_name'], 'lessor_id' => $data['lessor_id']])->update($data);
                } else { 
                    $data['contract_id'] = $contractId;
                    CounterOffer::create($data);
                }
                $reviewController->createPdf($data['domain_name'],$request);
                $params = $this->docusignClickWrap($data['domain_name']);
                if ($params['created_time']) {
                    \Session::put('docusign', $params);
                }
                $updateContract = [
                    'lease_total' => $data['first_payment'] + ($data['number_of_periods'] * $data['period_payment']),
                    'first_payment' => $request->first_payment,
                    'period_payment' => $request->period_payment,
                    'number_of_periods' => $request->number_of_periods,
                    'option_price' => $request->option_purchase_price,
                ];
                Session::put('updateContract', $updateContract);
            }

            //update lessee data
            if(is_null($data['lessor_id'])) {
                if(!empty($isLesseeData)) {
                    $isLessorData = CounterOffer::where(['domain_name' => $data['domain_name'], 'lessee_id' => $data['lessee_id']])->update($data);
                } else {
                    $data['contract_id'] = $contractId;
                    CounterOffer::create($data);
                }
                Session::flash('success', 'We have informed regarding your price...');
            }
            return redirect()->back()->withInput();
        } catch (Exception $e) {
            \Log::critical($e->getFile() . $e->getLine() . $e->getMessage());
            return redirect()->back()->with('msg', $e->getMessage());
        }
    }

    //counter lease 
    public function counterLease(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'first_payment' => 'required|numeric',
            'period_payment' => 'required|numeric',
            'number_of_periods' => 'required|numeric',
            'option_purchase_price' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }
        
        try {
            $data = $request->except('_token');
            $contract = Contract::where('contract_id', $data['contract_id'])->first();
            $data['domain_name'] = $contract->domain->domain;
            $data['lessee_id'] = Auth::user()->id;
            $data['from_email'] = Auth::user()->email;
            $vendorEmail = User::where('id', $data['lessor_id'])->pluck('email')->first();

            Mail::to($vendorEmail)->later(now()->addMinutes(1), new DomainReviewTerm($data));
            Session::flash('success', 'We have informed the owner regarding your price...');
            $isCounterOffer = CounterOffer::where('domain_name',$data['domain_name'])->where('lessee_id',Auth::user()->id)->first();
            if ($isCounterOffer) {
                $isCounterOffer->update($data);
            } else {
                unset($data['lessor_id']);
                CounterOffer::create($data);
            }
            return response()->json(['success' => true]);
        } catch (Exception $e) {
            \Log::critical($e->getFile() . $e->getLine() . $e->getMessage());
        }
    }

    //edit counter
    public function editCounter($id)
    {
        return Contract::find($id);
    }

    /**
     * Accept offer by lessor
     * @param $contractId
     * @param App\Http\Controllers\Front\ReviewController
     * @return response
     * GET accept/offer/{id}
     */
    public function acceptOffer($contractId,ReviewController $reviewController,DocusignController $docusign)
    {   
        $counterOffer = CounterOffer::where('contract_id',$contractId)->first();

        $this->convertLessorToLessee($counterOffer->domain_name);
        
        $diff_in_hours = docusignHourDifference();

        if ($diff_in_hours > 7) {
            $docusign->refreshToken();
        }

        if (Auth::user()->is_vendor == 'yes') {
            
            $updateCounter = $counterOffer->where('contract_id',$contractId)->select('first_payment','period_payment','number_of_periods',
            'option_purchase_price as option_price')->first()->toArray();

            $updateCounter['lease_total'] = $updateCounter['first_payment'] + ($updateCounter['number_of_periods'] * $updateCounter['period_payment']);
            
            $updateCounter['from_email'] = Auth::user()->email;
            
            $updateCounter['domain_name'] = $counterOffer->domain_name;

            $reviewController->createPdf($updateCounter['domain_name'],$updateCounter);
            $params = $this->docusignClickWrap($updateCounter['domain_name']);
            if ($params['created_time']) {
                \Session::put('docusign', $params);
            }
            \Session::put('updateCounter',$updateCounter);
            $toEmail = User::where('id',$counterOffer->lessee_id)->pluck('email')->first();
            Session::put('email', $toEmail); 
            return redirect()->back();
        }
    }

    /**
     * Update counter offer detail by lessor
     * @param $contractId
     * @param $request
     * @return response
     * GET update/counter-offer/{id}
     */
    public function updateCounterOffer(Request $request,$contractId)
    {   
        $request->flash();

        Session::forget('docusign');
        $updateContract = \Session::get('updateContract');
        
        $toEmail = Session::get('email'); 
        $data = Session::get('data');
        
        $updateCounter = Session::get('updateCounter');
        if(isset($updateCounter)) {
            $updateContract = $updateCounter;
            Mail::to($toEmail)->later(now()->addMinutes(1), new UserSetTermPriceDrop($updateCounter));
        } else {
            Mail::to($toEmail)->later(now()->addMinutes(1), new CounterLeaseVendor($data));
        }
        Contract::where('contract_id',$contractId)->update($updateContract);
        
        Session::forget('updateContract');
        Session::forget('email');
        Session::forget('updateCounter');
        Session::forget('data');
        Session::flash('success', 'We have informed the user regarding your price...');
    }
}
