<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // User List
    public function registered_user_list()
    {
        $users = User::get();
        return view('admin.user.users')
            ->with('users', $users)
            ->with('active', 'user');
    }

    //remove users
    public function remove_users($id)
    {
        User::find($id)->delete();
        return redirect()->back()->with('msg', 'User Successfully Removed');
    }

    //vendor User Approval
    public function approve_user_vendor($userId)
    {
        $user = User::where('id', $userId)->first();
        return view('admin.user.approve-user-vendor', compact('user'));
    }

    //Approval of vendor
    public function vendor_approval(Request $request)
    {
        $update = $request->except('_token', 'user_id');
        User::where('id', $request->user_id)->update($update);
        $user = User::where('id', $request->user_id)->first();
        if ($request->is_vendor == 'yes') {
            \Mail::send('emails.vendor-approval', ['user' => $user], function ($m) use ($user) {

                $m->from(\App\Models\Option::get_option('admin_email'), \App\Model\Option::get_option('site_title'));

                $m->to($user->email)->subject('You have been approved');
            });
            return back()->with('msg', 'User Successfully Approved');
        } else {
            return back()->with('msg', 'User Successfully Unapproved');
        }
    }
}
