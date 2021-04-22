<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Domain;
use App\Models\Commission;
use Illuminate\Http\Request;

class CommissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function sellerWiseCommission()
    {   
        $vendors = User::where('is_vendor','yes')->get();
        $active = 'seller-wise-commission';
        return view('admin.commission.index',compact('vendors','active'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function setCommission($userId)
    {   
        $domainCount = Domain::domainCount($userId);
        $active = 'commission';
        return view('admin.commission.set-commission',compact('domainCount','active'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function addCommission()
    {   
        $active = 'add-commission';
        return view('admin.commission.add-commission',compact('active'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function setContractCommission()
    {   
        $active = 'add-commission';
        $commissions = Commission::where('is_percentage','1')->get();
        return view('admin.commission.set-contract-commission',compact('active','commissions'));
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function setDomainCommission()
    {   
        $active = 'add-commission';
        $commissions = Commission::where('is_percentage','!=' ,'1')->get();
        return view('admin.commission.set-domain-commission',compact('active','commissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeDomainCommission(Request $request)
    {   
        $data = $request->all();
        foreach($data['from_domain'] as $key => $from) {
            if(isset($data['row_id'][$key])) {
                $update = Commission::where('id',$data['row_id'][$key])->update(['price'=>$data['commission'][$key]]);
            } else {
                $create = [
                    'from' => $from,
                    'to' => $data['to_domain'][$key],
                    'price' => $data['commission'][$key],
                    'is_percentage' => '0',
                ];
                Commission::create($create);
            }            
        }
        
        return redirect('admin/add-commission/')->with('success','commission successfully created');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeContractCommission(Request $request)
    {   
        $data = $request->all();
        foreach($data['from_domain'] as $key => $from) {
            if(isset($data['row_id'][$key])) {
                $update = Commission::where('id',$data['row_id'][$key])->update(['price'=>$data['commission'][$key]]);
            } else {
                $create = [
                    'from' => $from,
                    'to' => $data['to_domain'][$key],
                    'price' => $data['commission'][$key],
                    'is_percentage' => '1',
                ];
                Commission::create($create);
            }            
        }

        return redirect('admin/add-commission/')->with('success','Contract commission successfully created');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function removeDomainCommission(Request $request)
    {
        $update = Commission::where('id',$request->row_id)->delete();
        return true;
    }
}
