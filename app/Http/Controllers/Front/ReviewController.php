<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contract;
use App\Models\Domain;
use App\Models\GracePeriod;
use App\Models\PeriodType;
use App\Models\OptionExpiration;
use Carbon\Carbon;
use App\Traits\CalculatePeriodTrait;
use App\Models\User;
use PDF;
use Auth;
use Illuminate\Support\Facades\Mail;
use Session;
use App\Mail\DomainReviewTerm;

class ReviewController extends Controller
{
    use CalculatePeriodTrait;

    public function index(Request $request, $domainName)
    {

        $domain = Domain::where('domain', $domainName)->first();
        $lessor = User::where('id', $domain->user_id)->first();

        $contracts = Contract::where('domain_id', $domain->id)->firstorFail();
        $graces = GracePeriod::all();

        $periods = PeriodType::all();
        $periodDays = $periods->where('id', $contracts->period_type_id);

        $periodType = $periods->where('id', $contracts->period_type_id)->first()->period_type;
        $endOfLease = $this->calculatePeriod($periodDays, $contracts->number_of_periods);

        $options = OptionExpiration::all();
        $leasetotal = $contracts->first_payment + ($contracts->number_of_periods *
            $contracts->period_payment);

        $mytime = Carbon::now();
        $getCurrentDateTime =  $mytime->toDateTimeString();

        if (Auth::check()) {

            $this->createPdf($domainName, $domain, $lessor, $contracts, $periods, $periodType, $options, $leasetotal, $getCurrentDateTime, $graces, $endOfLease);

            return view('front.review.terms', compact(
                'graces',
                'periods',
                'options',
                'domain',
                'contracts',
                'domainName',
                'leasetotal',
                'getCurrentDateTime',
                'endOfLease',
                'periodType',
                'lessor'
            ));
        } else {

            return redirect()->to(route('login'));
        }
    }


    private function createPdf($domainName, $domain, $lessor, $contracts, $periods, $periodType, $options, $leasetotal, $getCurrentDateTime, $graces, $endOfLease)
    {
        $pdf = PDF::loadView('front.review.pdf-terms', compact(
            'graces',
            'periods',
            'options',
            'domain',
            'contracts',
            'domainName',
            'leasetotal',
            'getCurrentDateTime',
            'endOfLease',
            'periodType',
            'lessor'
        ));
        $filename = 'contract_' . $lessor->id . '.pdf';

        \Storage::put('public/pdf/' . $filename, $pdf->output());
        // $pdf->save('doc/'.$filename);
    }


    //counter lease
    public function counterLease(Request $request)
    {
        $domainId = Domain::pluck('user_id')->first();

        $VendorEmail = User::where('id', $domainId)->pluck('email')->first();

        $validator = \Validator::make($request->all(), [
            'first_payment' => 'required|numeric',
            'period_payment' => 'required|numeric',
            'number_of_periods' => 'required|numeric',
            'option_price' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
        try {
            $data = [
                'first_payment' => $request->first_payment,
                'period_payment' => $request->period_payment,
                'number_of_periods' => $request->number_of_periods,
                'option_price' => $request->option_price,
            ];
            Mail::to($VendorEmail)->later(now()->addMinutes(1), new DomainReviewTerm($data));
            Session::flash('success', 'We have informed the owner regarding your price...');

            return redirect()->back();
        } catch (Exception $e) {
            \Log::critical($e->getFile() . $e->getLine() . $e->getMessage());
        }
    }

    //edit counter
    public function editCounter($id)
    {
        return Contract::find($id);
    }
}
