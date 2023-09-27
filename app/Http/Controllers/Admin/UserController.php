<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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

                $m->from(\App\Models\Option::get_option('admin_email'), \App\Models\Option::get_option('site_title'));

                $m->to($user->email)->subject('You have been approved');
            });
            return back()->with('msg', 'User Successfully Approved');
        } else {
            return back()->with('msg', 'User Successfully Unapproved');
        }
    }

    /**
     * this function will create user
     * 
     * @method GET /admin/user/create
     * @return render view
     */
    public function create_user()
    {
        return view('admin.user.create');
    }

    /**
     * this function will create user
     * 
     * @param \Illuminate\Http\Request $request
     * @method GET /admin/user/store
     * @return render view
     */
    public function store_user(Request $request)
    {
        if ($request->selected_user == 'admin') {
            $data = $request->all();
            $data['admin'] = '1';
            $data['email_verified_at'] = date('Y-m-d H:i:s');
            $data['password'] = Hash::make($request->password);
            User::create($data);
            return back()->with('msg', 'Admin User Successfully Created');
        } else if ($request->selected_user == 'customer') {
            $data = $request->all();
            $data['password'] = Hash::make($request->password);
            User::create($data);
            return back()->with('msg', 'Customer Successfully Created');
        } else if ($request->selected_user == 'vendor') {
            $data = $request->all();
            $data['is_vendor'] = 'yes';
            $data['password'] = Hash::make($request->password);
            User::create($data);
            return back()->with('msg', 'Vendor Successfully Created');
        }
    }

    /**
     * Edit the user
     * @method GET /admin/user/edit/{user}
     * @param User $user
     * @return Renderable|RedirectResponse
     */

    public function editUser(User $user): Renderable | RedirectResponse
    {
        try {
            //dd($user);
            return view('admin.user.edit', compact('user'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Edit the user
     * @method POST /admin/user/update/{user}
     * @param User $user
     * @param UserUpdateRequest $request
     * @return RedirectResponse
     */

    public function updateUser(User $user, UserUpdateRequest $request): RedirectResponse
    {
        try {
            if ($request->user_type == 'admin') {
                $user->update($request->only('name', 'email'));
                $user->update(['admin' => 1]);
            } elseif ($request->user_type == 'vendor') {
                $user->update($request->only('name', 'email', 'phone', 'company', 'country', 'state', 'city', 'street_1', 'street_2', 'zip'));
                $user->update(['admin' => 0, 'is_vendor' => 'yes']);
            } elseif ($request->user_type == 'user') {
                $user->update($request->only('name', 'email', 'phone', 'company', 'country', 'state', 'city', 'street_1', 'street_2', 'zip'));
                $user->update(['admin' => 0, 'is_vendor' => 'no']);
            }
            if ($request->has('password') && $request->password != null) {
                $user->update(['password' => Hash::make($request->password)]);
            }
            return redirect()->route('admin.users')->with('success', 'User Updated Successfully');
        } catch (Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
