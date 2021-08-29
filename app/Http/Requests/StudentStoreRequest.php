<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentStoreRequest extends FormRequest
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
            'first' => ['required', 'string'],
            'middle' => ['nullable', 'string'],
            'last' => ['required', 'string'],
            'pronoun_id' => ['required', 'numeric'], //drop-down; may be default 1

            /*STUDENT*/
            'birthday' => ['required', 'date'], //birthday required to identify <13 years-of-age for COPPA regulations
            'classof' => ['required', 'numeric'], //drop-down; may be zero
            'height' => ['required', 'numeric'], //drop-down; may be zero
            'shirtsize_id' => ['required', 'numeric'], //drop-down; may be zero

            /*EMAILS*/
            'email_student_personal' => ['nullable', 'email:rfc'],
            'email_student_school' => ['nullable', 'email:rfc','different:emails.0'],

            /*PHONES*/
            'phone_student_mobile' => ['nullable','phone_number', 'min:10'],
            'phone_student_home' => ['nullable','phone_number', 'min:10'],

            /*CHORALS*/
            'chorals' => ['required','array', 'min:1', 'max:3'],
            'chorals.0' => ['nullable', 'numeric'],
            'chorals.1' => ['nullable', 'numeric'],
            'chorals.2' => ['nullable', 'numeric'],

            /*INSTRUMENTALS*/
            'instrumentals' => ['nullable', 'array', 'min:3', 'max:3'],
            'instrumentals.0' => ['nullable', 'numeric'],
            'instrumentals.1' => ['nullable', 'numeric'],
            'instrumentals.2' => ['nullable', 'numeric'],

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
            /*PERSON*/
            //use default messages

            /*STUDENT*/
            //use default messages

            /*EMAILS*/
            'emails.0.rfc' => 'The domain extension is not valid.',
            'emails.1.rfc' => 'The domain extension is not valid.',
            'emails.0.unique' => 'This email matches another in the system.'."\n".'Please see your Director if you are using a common, family or shared email address.',
            'emails.1.unique' => 'This email matches another in the system.'."\n".'Please see your Director if you are using a common, family or shared email address.',
            'emails.1.different' => 'You cannot use the same email for both primary and alternate values.',

            /*PHONES*/
            'phones.1.phone_number' => 'The phone number must include area code.',

            'chorals.required' => 'Select a voice part',
            'chorals.0.numeric' => 'Select a primary voice part.',
            'chorals.1.numeric' => 'Select a secondary voice part.',
            'chorals.2.numeric' => 'Select an alternate voice part',
            'class_of.required' => 'You must select class or grade.',
            'height.numeric' => 'A numeric value is requried (height in inches).',
            'birthday.date' => 'Select a valid birthday date.',
            'shirt_size.numeric' => 'You must select a shirt size.',
            'instrumentals.required' => 'Select an instrument',
            'instrumentals.0.numeric' => 'Select a primary instrument.',
            'instrumentals.1.numeric' => 'Select a secondary instrument.',
            'instrumentals.2.numeric' => 'Select an alternate instrument.',
        ];
    }
}

