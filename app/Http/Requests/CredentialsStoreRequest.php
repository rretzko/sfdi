<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CredentialsStoreRequest extends FormRequest
{
    protected $redirectAction = 'HomeController@credentials';

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
            'password_confirmation' => 'required',
            'current_password' => [
                'required',
                'password'
                ],
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[!@#$%^&*()-_=+]/',
                'confirmed'
                ]
            ];
    }

    /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages()
    {
        return [
            'password.required' => 'eh eh ehhhh, you must enter a password',
            'password_confirmation.required' => 'You must enter a confirmation password.',

        ];
    }


}
