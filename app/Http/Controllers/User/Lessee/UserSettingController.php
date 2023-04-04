<?php

namespace App\Http\Controllers\User\Lessee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\Order;
use App\Models\GracePeriod;
use App\Models\PeriodType;
use App\Models\OptionExpiration;
use App\Models\Contract;
use App\Models\CounterOffer;
use App\Models\Dns;
use App\Models\User;
use App\Models\Domain;
use Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class UserSettingController extends Controller
{
    /**
     *  Use to update user details
     */
    public function userUpdate(Request $request)
    { 
        try {
            $user = User::findOrFail(Auth::user()->id);
        
            $userData = $request->all();
            if (isset($userData['is_vendor'])) {
                \Mail::send('emails.apply-for-vendor', ['user' => $user], function ($m) use ($user) {
                    $m->from('info@identitus.com', \App\Models\Option::get_option('site_title'));
                    $m->to(\App\Models\Option::get_option('admin_email'))->subject('Applied for vendor');
                });
    
                $userData['is_vendor'] = 'pending';
            } else {
                $userData['is_vendor'] = $user->is_vendor;
            }
            
            if (!empty($userData['old_password'])) {
                if (Hash::check($userData['old_password'], $user->password)) {
                    $user->fill([
                        'password' => Hash::make($userData['new_password']),
                        'name' => $userData['name'],
                        'email' => $userData['email'],
                        'phone' => $userData['phone'],
                        'company' => $userData['company'],
                        'country' => $userData['country'],
                        'state' => $userData['state'],
                        'city' => $userData['city'],
                        'street_1' => $userData['street_1'],
                        'street_2' => $userData['street_2'],
                        'zip' => $userData['zip'],
                        'is_vendor' => $userData['is_vendor'],
                    ])->save();
    
                    $request->session()->flash('msg', 'Your profile has been updated');
                } else {
                    $request->session()->flash('msg', 'Password does not match');
                }
            } else {
    
                $request->session()->flash('msg', 'Your profile has been updated');
                if (isset($userData['is_vendor']) && $userData['is_vendor'] == 'pending') {
                    $request->session()->flash('msg', 'Thank for applying, Will back you soon !');
                }
                $user->fill($userData)->save();
            }
    
            return redirect()->back();
        } catch (\Exception $e) { 
            Log::info($e->getMessage());
        }

       
    }

    /**
     *  User Index Page
     */
    public function index()
    {
        return view('user.lessee.base');
    }

    /**
     *  Handle user data
     */
    public function userProfile(Request $request)
    {
        $userId = Auth::id();
        $user = User::find($userId);
        return view('user.lessee.profile')
            ->with('active', 'user')
            ->with('user', $user);
    }

    /**
     *  Handle user orders
     */
    public function userOrders()
    {

        $userId = Auth::id();
        $user = User::find($userId);

        $userEmail = $user->email;
        $orders = Order::where('email', $userEmail)->get();

        if (count($orders) > 0) {
            $data = json_decode($orders[0]->order_contents);
        }
        return view('user.lessee.orders')
            ->with('active', 'orders')
            ->with('orders', $orders);
    }

    /**
     *  Manage User Domain's Rent
     */
    public function rentalAgreement()
    {

        $userId = Auth::id();
        $lease = \DB::table('contracts')
            ->leftjoin('domains', 'domains.id', '=', 'contracts.domain_id')
            ->leftjoin('users', 'users.id', '=', 'contracts.lessee_id')
            ->where('domains.domain_status', 'LEASE')
            ->where('contracts.lessee_id', $userId)
            ->get();

        $gracePeriod = GracePeriod::get();
        $periodTypes = PeriodType::get();
        $optionExpiration = OptionExpiration::get();

        return view('user.lessee.rental-agreement')
            ->with('active', 'rental-agreement')
            ->with('lease', $lease)
            ->with('gracePeriod', $gracePeriod)
            ->with('periodTypes', $periodTypes)
            ->with('optionExpiration', $optionExpiration);
    }

    /**
     *  User Add Dns
     */
    public function addDns($domainId)
    {
        $userId = Auth::id();
        $dns = Dns::where('domain_id', $domainId)->first();
        return view('user.lessee.dns', compact('domainId', 'dns'));
    }

    /**
     *  Store Dns
     */
    public function storeDns(Request $request)
    {

        $data = $request->except('_token');
        $data['user_id'] = Auth::id();

        $isDomain = Dns::where('domain_id', $request->domain_id)->first();

        if (isset($isDomain)) {
            Dns::where('domain_id', $request->domain_id)->update($data);
            return back()->with('msg', 'Dns updated successfully');
        } else {
            Dns::create($data);
            return back()->with('msg', 'Dns added successfully');
        }
    }

    /**
     *  View Order
     * 
     */
    public function view_order($id)
    {
        $order = Order::where('id', $id)->first();

        // order contents unserialize
        $order_content = json_decode($order->order_contents);
        
        return view('user.lessee.view-order')
            ->with('active', 'orders')
            ->with('order', $order)
            ->with('order_content', $order_content);
    }

    /**
     * 
     *  View Terms
     *  @param string $domainName
     *  GET user/view-terms/{domainName}
     *  @return renderable
     */
    public function viewTerms($domainName)
    {

        $graces = GracePeriod::all();
        $periods = PeriodType::all();
        $options = OptionExpiration::all();

        $domainId = Domain::where('domain', $domainName)->first()->id;
        $isLease = Domain::where('domain', $domainName)->first()->domain_status;
        $contracts = Contract::where('domain_id', $domainId)->first();
        $counterOffer = CounterOffer::where('domain_name', $domainName)->where('lessor_id', NULL)->first();
        
        if ($counterOffer) {
            $counterOffer->option_price = $counterOffer->option_purchase_price;
            $contracts = $counterOffer;
        }
        if (empty($contracts)) {
            $contracts = [];
        }

        return view('user.lessee.view-terms', compact('graces', 'periods', 'options', 'domainId', 'contracts', 'domainName', 'isLease'));
    }

    /**
     *  Logout User
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect('/');
    }

    /**
     * this function is used to show contract
     * @param string $domainID
     * @return renderable
     */
    public function showContract($domainId)
    {   
        $filename = 'pdf/domain_contract_' . $domainId . '.pdf';
        $contractPath = Storage::disk('public')->path($filename);
        return view('user.lessee.view-contract',compact('domainId'))->render();
    }
}
