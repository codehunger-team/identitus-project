<?php

namespace App\Http\Controllers\User\Lessor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\Dns;

class LessorController extends Controller
{
    /**
     * View Dns
     * 
    */
    public function ViewDns($domainId)
    {
        $userId = Auth::id();
        $dns = Dns::where('domain_id', $domainId)->first();
        return view('user.lessor.domain.dns', compact('domainId', 'dns'));
    }

    /**
     * Add Terms
     * 
    */
    public function add_terms(Request $request)
    {

        $this->validate($request, ['first_payment' => 'required|numeric',
            'number_of_periods' => 'required|numeric',
            'period_payment' => 'required|numeric',
        ]);

        $data = [
            'period_payment' => $request->period_payment,
            'period_type_id' => $request->period_type_id,
            'number_of_periods' => $request->number_of_periods,
            'option_price' => $request->option_price,
            'option_expiration' => 6,
            'grace_period_id' => 4,
            'domain_id' => $request->domain_id,
            'lessor_id' => Auth::id(),
            'first_payment' => $request->first_payment,
            'auto_change_rate' => 0,
            'accrual_rate' => 0,
            'lease_total' => $request->first_payment + ($request->number_of_periods * $request->period_payment),
        ];


        $contractData = Contracts::where('domain_id', $request->domain_id)->first();
        if ($contractData) {
            $contractData->update($data);
            return redirect('user/set-terms/' . $request->domain)->with('msg', 'Successfully updated');
        } else {
            Contracts::create($data);
            return redirect('user/set-terms/' . $request->domain)->with('msg', 'Successfully Added');
        }
    }

}
