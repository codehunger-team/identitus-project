<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'user_type' => 'required|in:admin,user,vendor',
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email,' . $this->user_id,
            'phone' => 'sometimes|digits:10',
            'company' => 'sometimes|min:3',
            'country' => 'sometimes|min:3',
            'state' => 'sometimes|min:2',
            'city' => 'sometimes|min:2',
            'street_1' => 'sometimes|min:3',
            'street_2' => 'sometimes|min:3',
            'zip' => 'sometimes|min:3',
            'password' => 'sometimes|nullable|confirmed',
        ];
    }
}
