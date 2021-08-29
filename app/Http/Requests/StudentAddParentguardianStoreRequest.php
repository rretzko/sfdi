<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentAddParentguardianStoreRequest extends FormRequest
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
     * Apply custom error messages as needed
     *
     * @return array
     */
    public function messages()
    {
        return [
            'parentguardiantype' => 'You must select a Parent type.',
            'phones.required' => 'You must select at least one phone.'
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first' => 'required',
            'last' => 'required',
            'parentguardiantype' => 'required|numeric',
            'email_guardian_primary' => ['nullable', 'email'],
            'email_guardian_alternate' => ['nullable', 'email'],
            'phone_guardian_home' => ['nullable','string'],
            'phone_guardian_mobile' => ['nullable', 'string'],
            'phone_guardian_work' => ['nullable', 'string']
        ];
    }
}
