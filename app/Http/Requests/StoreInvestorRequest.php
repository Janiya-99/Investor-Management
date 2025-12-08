<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInvestorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [

            'title' => 'required|string|max:50',

            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'full_name' => 'required|string|max:255',

            'email' => 'required|email|max:255|unique:investors,email,' . $this->investor,

            'nic' => 'nullable|string|max:20|unique:investors,nic,' . $this->investor,

            'contact_no' => 'nullable|string|max:20',

            'address_line_1' => 'nullable|string',
            'address_line_2' => 'nullable|string',
            'address_line_3' => 'nullable|string',

            'beneficiary_full_name' => 'nullable|string|max:255',
            'beneficiary_nic' => 'nullable|string|max:20',
            'beneficiary_contact_no' => 'nullable|string|max:20',
            'beneficiary_relation' => 'nullable|string|max:255',

            'registration_date' => 'nullable|date',

            'last_updated_date_time' => 'nullable|date',

            'last_updated_by' => 'nullable|integer|exists:users,id',
            'created_by' => 'nullable|integer|exists:users,id',

            'tax_status' => 'nullable|string|max:50',
            'tax_no' => 'nullable|string|max:50',

            'otp' => 'nullable|string|max:10',

            'status' => 'required|boolean',
        ];


    }

    public function messages(): array
    {
        return [
            'email.required' => 'The email field is required.',
            'email.email' => 'The email must be a valid email address.',
            'email.unique' => 'The email has already been taken.',

            'nic.unique' => 'The NIC has already been taken.',

            'last_updated_by.exists' => 'The selected last updated by user does not exist.',
            'created_by.exists' => 'The selected created by user does not exist.',

            'status.required' => 'The status field is required.',
            'status.boolean' => 'The status field must be true or false.',
        ];
    }


}
