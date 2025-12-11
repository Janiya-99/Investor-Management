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
        $id = $this->route('investor')?->id;
        return [
            'title' => 'required|string|max:50',

            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'full_name' => 'required|string|max:255',

            'email' => 'required|email|max:255|unique:investors,email,' . $id,
            'nic' => 'required|string|max:20|unique:investors,nic,' . $id,

            'contact_no' => 'required|string|max:20',

            'password' => $id ? 'sometimes|nullable|string|min:8' : 'nullable|string|min:8',

            'address_line_1' => 'required|string',
            'address_line_2' => 'required|string',
            'address_line_3' => 'required|string',

            'beneficiary_full_name' => 'required|string|max:255',
            'beneficiary_nic' => 'required|string|max:20',
            'beneficiary_contact_no' => 'required|string|max:20',
            'beneficiary_relation' => 'required|string|max:255',

            'registration_date' => 'required|date',

            'tax_status' => 'required|string|max:50',
            'tax_no' => 'required|string|max:50',
            
            'documents' => 'nullable|array|min:0',
            'documents.*.description' => 'required_with:documents.*.document_path|string|max:255',
            'documents.*.document_path' => 'required_with:documents.*.description|file|mimes:jpg,jpeg,png,pdf|max:2048',

            'banks' => 'required|array|min:1',
            'banks.*.bank_id' => 'required|exists:banks,id',
            'banks.*.bank_branch_id' => 'required|exists:bank_branches,id',
            'banks.*.account_number' => 'required|string|max:50',
            'banks.*.account_name' => 'required|string|max:255',
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
