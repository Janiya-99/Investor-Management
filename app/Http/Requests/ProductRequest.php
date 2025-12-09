<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'period_type' => 'required|string|in:days,weeks,months,years',
            'period' => 'required|integer|min:1',
            'min_interest_rate' => 'required|numeric|min:0',
            'max_interest_rate' => 'required|numeric|min:0|gte:min_interest_rate',
            'min_amount' => 'required|numeric|min:0',
            'max_amount' => 'required|numeric|min:0|gte:min_amount',
            'interest_calculation_type' => 'required|string|in:simple,compound',
            'capital_withdrawal_notice_period' => 'nullable|integer|min:0',
            'penalty_type' => 'nullable|string|in:fixed,percentage',
            'penalty_min_rate' => 'nullable|numeric|min:0',
            'penalty_max_rate' => 'nullable|numeric|min:0|gte:penalty_min_rate',
            'status' => 'required|boolean',
            'created_by' => 'nullable|integer|exists:users,id',
            'last_updated_by' => 'nullable|integer|exists:users,id',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The product name is required.',
            'period_type.in' => 'The period type must be one of the following: days, weeks, months, years.',
            'interest_calculation_type.in' => 'The interest calculation type must be either simple or compound.',
            'status.boolean' => 'The status must be true or false.',
            'created_by.exists' => 'The selected creator is invalid.',
            'last_updated_by.exists' => 'The selected updater is invalid.',
        ];
    }
}
