<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactUsRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'firstname'    => ['required', 'string'],
            'lastname'     => ['required', 'string'],
            'email'        => ['required', 'email'],
            // 'match_pay_id' => ['required', 'string'],
            'phone'        => ['required', 'regex:/(01)[0-9]{9}/'],
            // 'topics'       => ['required', 'string'],
            'message'      => ['required', 'string'],
        ];
    }
}
