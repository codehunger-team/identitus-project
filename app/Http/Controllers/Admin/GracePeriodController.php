<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GracePeriod;

class GracePeriodController extends Controller
{
    // Grace Overview
    public function grace_overview()
    {

        $grace = GracePeriod::orderBy('id', 'DESC')->get();

        return view('admin.grace-period.grace-period')
            ->with('active', 'grace-period')
            ->with('grace', $grace);
    }

    // Grace Option
    public function add_grace(Request $r)
    {

        $this->validate($r, ['grace_period' => 'required']);

        $g = new GracePeriod;
        $g->grace_period = $r->grace_period;
        $g->save();

        return redirect('admin/grace-period')->with('msg', 'Grace Period successfully created.');

    }

    //edit period
    public function edit_grace($graceId)
    {

        $g = GracePeriod::FindOrFail($graceId);
        $grace = GracePeriod::orderBy('id', 'DESC')->get();
        return view('admin.grace-period.grace-period', compact('grace', 'g'));
    }

    // update period
    public function update_grace(Request $r)
    {
        $this->validate($r, ['grace_period' => 'required']);

        $g = GracePeriod::findOrFail($r->graceId);
        $g->grace_period = $r->grace_period;
        $g->save();

        return redirect('admin/grace-period')->with('msg', 'Grace option successfully updated.');

    }

    // remove grace
    public function remove_grace($optionID)
    {

        $d = GracePeriod::findOrFail($optionID);
        $d->delete();
        return redirect('admin/grace-period')->with('msg', 'Successfully removed category "' . $d->grace_period . '"');
    }
}
