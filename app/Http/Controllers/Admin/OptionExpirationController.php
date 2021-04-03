<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OptionExpirationController extends Controller
{
    // Option Overview
    public function option_overview()
    {

        $options = OptionExpirations::orderBy('id', 'DESC')->get();

        return view('admin.option-expiration')
            ->with('active', 'option')
            ->with('options', $options);
    }

    // add period
    public function add_option(Request $r)
    {

        $this->validate($r, ['option_expiration' => 'required']);

        $o = new OptionExpirations;
        $o->option_expiration = $r->option_expiration;
        $o->save();

        return redirect('admin/option-expiration')->with('msg', 'Option Expiration successfully created.');

    }

    //edit period
    public function edit_option($optionID)
    {

        $o = OptionExpirations::FindOrFail($optionID);

        $options = OptionExpirations::orderBy('id', 'DESC')->get();

        return view('admin.option-expiration', compact('options', 'o'));
    }

    // update period
    public function update_option(Request $r)
    {

        $this->validate($r, ['option_expiration' => 'required']);

        $p = OptionExpirations::findOrFail($r->optionId);
        $p->option_expiration = $r->option_expiration;
        $p->save();

        return redirect('admin/option-expiration')->with('msg', 'Option Expiration successfully updated.');

    }

    // remove period
    public function remove_option($optionID)
    {

        $d = OptionExpirations::findOrFail($optionID);
        $d->delete();
        return redirect('admin/option-expiration')->with('msg', 'Successfully removed category "' . $d->option_expiration . '"');
    }
}
