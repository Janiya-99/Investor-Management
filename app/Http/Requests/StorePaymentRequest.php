<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePaymentRequest extends FormRequest
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
            'investment_id' => ['required', 'exists:investments,id'],
            'investor_bank_details_id' => ['nullable', 'exists:investor_has_bank_details,id'],
            'user_id' => ['nullable', 'exists:users,id'],
            'payment_date' => ['required', 'date'],
            'amount' => ['required', 'numeric', 'min:0.01'],
            'type' => ['required', Rule::in(['capital', 'interest', 'penalty', 'other'])],
            'status' => ['required', Rule::in(['pending', 'posted', 'void'])],
            'note' => ['nullable', 'string'],
        ];
    }
}
