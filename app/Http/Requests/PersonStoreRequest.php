<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PersonStoreRequest extends FormRequest
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
     * NOTE: applying "different:emails.0" validation to emails.1 understanding 
     * that x@example.com !== X@example.com.  
     * 
     * @todo Need rule to reject strtolower(emails.0) === strtolower(emails.1) 
     * @todo Need rule to reject duplicate emails (encrypted + hashed)
     *  - except for the current user
     *  - except where family-email is checked
     * 
     * @return array
     */
    public function rules()
    {
        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'pronoun_id' => 'required|numeric',
            'emails.0' => ['required','email','unique:App\Email,email'],//new \App\Rules\DuplicateUniqueEmail],
            'emails.1' => 'email|nullable|different:emails.0',
            'phones.0' => ['nullable', new \App\Rules\PhoneNumber], 
            'phones.1' => ['nullable', 'different:phones.0', new \App\Rules\PhoneNumber], 
        ];
        
        /*if(strlen($this->attributes->get('emails.0')) && 
                (!$this->attributes->has('family_primary'))){
            
            $rules['emails.0'] = 'required';
        }
        
        if(strlen($this->attributes->get('emails.1'))){
            
            $rules['emails.1'] = 'required';
        }*/
        
        return $rules;
    }
    
    /**
     * Custom message for validation
     * 
     * @return array
     */
    public function messages()
    {
        return [
            'first_name.required' => 'You must enter a first name.',
            'last_name.required' => 'You must enter a last name.',
            'emails.0.required' => 'At least one email must be entered. '
            . 'Please see your Director if you do not have an email address.',
            'emails.0.email'=> 'The required email is missing or has an incorrect format.',
            'emails.0.unique' => 'Your required email is registered to another student.',
            'emails.1.email'=> 'The optional email is missing or has an incorrect format.',
            'emails.1.different' => 'Primary and Alternate emails cannot be the same.',
            //'emails.*.email.distinct' => 'The alternative email cannot be the same as the primary email.'
        ];
    }
}
