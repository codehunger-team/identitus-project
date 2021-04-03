<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PeriodController extends Controller
{
    // Period Overview
    public function period_overview()
    {

        $periods = PeriodTypes::orderBy('period_type', 'ASC')->get();

        return view('admin.period-type')
            ->with('active', 'period')
            ->with('periods', $periods);
    }

    // add period
    public function add_period(Request $r)
    {

        $this->validate($r, ['period_type' => 'required']);

        $p = new PeriodTypes;
        $p->period_type = $r->period_type;
        $p->save();

        return redirect('admin/period-types')->with('msg', 'Period successfully created.');

    }

    //edit period
    public function edit_period($periodID)
    {

        $p = PeriodTypes::FindOrFail($periodID);

        $periods = PeriodTypes::orderBy('period_type', 'ASC')->get();

        return view('admin.period-type', compact('periods', 'p'));
    }

    // update period
    public function update_period(Request $r)
    {

        $this->validate($r, ['period_type' => 'required']);

        $p = PeriodTypes::findOrFail($r->periodId);
        $p->period_type = $r->period_type;
        $p->save();

        return redirect('admin/period-types')->with('msg', 'Category successfully updated.');

    }

    // remove period

    public function remove_period($periodID)
    {

        $d = PeriodTypes::findOrFail($periodID);
        $d->delete();
        return redirect('admin/period-types')->with('msg', 'Successfully removed category "' . $d->period_type . '"');
    }
}
