<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed', Password::min(8)
                ->mixedCase()
                ->numbers()
                ->symbols()
                ->uncompromised(),],
            'phone' => ['required', 'numeric', 'digits:10'],
            'country' => ['required'],
            'state' => ['required'],
            'city' => ['required'],
            'street_1' => ['required'],
            'zip' => ['required'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {   
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'phone' => $data['phone'],
            'country' => $data['country'],
            'state' => $data['state'],
            'city' => $data['city'],
            'street_1' => $data['street_1'],
            'zip' => $data['zip'],
            'is_tos' => $data['is_tos'],
            'is_agreement' => $data['is_agreement'],
            'ip_address' => $_SERVER['REMOTE_ADDR'],
        ]);
    }

    /**
     * Check if user account exists
     * @method POST /register/check-if-account-exists
     * @param Request $request
     * @return JSON
     */

    public function checkIfAccountExists(Request $request)
    {
        try {
            $request->validate(['email' => 'required|email']);
            $exists = User::where('email', $request->email)->exists();
            return response()->json(['success' => true, 'exists' => $exists]);
        } catch (Exception $e) {
            return response()->json(['success' => true, 'message' => $e->getMessage()], 422);
        }
    }
}
