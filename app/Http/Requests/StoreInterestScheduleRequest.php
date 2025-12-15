<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInterestScheduleRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'investment_id' => ['required', 'exists:investments,id'],
            'due_date' => ['required', 'date'],
            'interest_amount' => ['required', 'numeric', 'min:0'],
            'capital_amount' => ['nullable', 'numeric', 'min:0'],
            'paid_at' => ['nullable', 'date'],
            'paid_amount' => ['nullable', 'numeric', 'min:0'],
            'status' => ['required', 'in:pending,scheduled,paid,overdue,cancelled'],
            'note' => ['nullable', 'string'],
        ];
    }
}

