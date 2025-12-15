<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateInvestmentRequest extends FormRequest
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
            'investor_id' => ['required', 'exists:investors,id'],
            'product_id' => ['nullable', 'exists:products,id'],
            'investor_bank_details_id' => ['nullable', 'exists:investor_has_bank_details,id'],
            'investment_amount' => ['required', 'numeric', 'min:0.01'],
            'interest_rate' => ['required', 'numeric', 'min:0'],
            'period_type' => ['required', 'string', 'max:50'],
            'period' => ['required', 'integer', 'min:1'],
            'start_date' => ['required', 'date'],
            'maturity_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'capital_withdrawal_notice_period' => ['required', 'integer', 'min:0'],
            'penalty_rate' => ['nullable', 'numeric', 'min:0'],
            'status' => ['required', Rule::in(['draft', 'active', 'closed', 'cancelled'])],
            'notes' => ['nullable', 'string'],
        ];
    }
}
