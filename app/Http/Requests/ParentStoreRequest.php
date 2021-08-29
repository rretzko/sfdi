<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ParentStoreRequest extends FormRequest
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
            /*PERSON*/
            'first_name' => ['required', 'string'],
            'middle_name' => ['nullable', 'string'],
            'last_name' => ['required', 'string'],
            
            /*PARENT*/
            'parentguardiantype' => ['required', 'numeric'],
            
            /*EMAILS*/
            'emails.0' => ['nullable', 'email:rfc'],
            'emails.1' => ['nullable', 'email:rfc','different:emails.0'],
            
            /*PHONES*/
            'phones.0' => ['nullable','phone_number', 'min:10'],
            'phones.1' => ['nullable','phone_number', 'min:10'],
            
        ];
    }
}
