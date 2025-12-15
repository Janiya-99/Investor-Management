<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInvestorBankDetailsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'investor_id' => 'required|exists:investors,id',
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
            'investor_id.required' => 'Please choose an investor.',
            'investor_id.exists' => 'The selected investor was not found.',
            'banks.required' => 'Add at least one bank account.',
            'banks.*.bank_id.required' => 'Select a bank.',
            'banks.*.bank_id.exists' => 'Selected bank is invalid.',
            'banks.*.bank_branch_id.required' => 'Select a branch.',
            'banks.*.bank_branch_id.exists' => 'Selected branch is invalid.',
            'banks.*.account_number.required' => 'Enter the account number.',
            'banks.*.account_name.required' => 'Enter the account name.',
        ];
    }
}

