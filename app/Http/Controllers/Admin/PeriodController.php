<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PeriodType;

class PeriodController extends Controller
{
    // Period Overview
    public function period_overview()
    {

        $periods = PeriodType::orderBy('period_type', 'ASC')->get();

        return view('admin.period.period-type')
            ->with('active', 'period')
            ->with('periods', $periods);
    }

    // add period
    public function add_period(Request $r)
    {

        $this->validate($r, ['period_type' => 'required']);

        $p = new PeriodType;
        $p->period_type = $r->period_type;
        $p->save();

        return redirect('admin/period-types')->with('msg', 'Period successfully created.');

    }

    //edit period
    public function edit_period($periodID)
    {

        $p = PeriodType::FindOrFail($periodID);

        $periods = PeriodType::orderBy('period_type', 'ASC')->get();

        return view('admin.period.period-type', compact('periods', 'p'));
    }

    // update period
    public function update_period(Request $r)
    {

        $this->validate($r, ['period_type' => 'required']);

        $p = PeriodType::findOrFail($r->periodId);
        $p->period_type = $r->period_type;
        $p->save();

        return redirect('admin/period-types')->with('msg', 'Category successfully updated.');

    }

    // remove period

    public function remove_period($periodID)
    {

        $d = PeriodType::findOrFail($periodID);
        $d->delete();
        return redirect('admin/period-types')->with('msg', 'Successfully removed category "' . $d->period_type . '"');
    }
}
