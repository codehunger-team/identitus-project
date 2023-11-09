<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PwaConfigurationStoreRequest extends FormRequest
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
            'pwa_app_72_72_icon' => 'sometimes|mimes:png|dimensions:min_width:72,min_height=72,max_width=72,max_height=72',
            'pwa_app_96_96_icon' => 'sometimes|mimes:png|dimensions:min_width:96,min_height=96,max_width=96,max_height=96',
            'pwa_app_128_128_icon' => 'sometimes|mimes:png|dimensions:min_width:128,min_height=128,max_width=128,max_height=128',
        ];
    }
}
