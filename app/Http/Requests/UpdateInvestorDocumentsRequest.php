<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInvestorDocumentsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'investor_id' => 'required|exists:investors,id',
            'documents' => 'required|array|min:1',
            'documents.*.description' => 'required_with:documents.*.document_path|string|max:255',
            'documents.*.document_path' => 'required_with:documents.*.description|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'investor_id.required' => 'Please choose an investor.',
            'investor_id.exists' => 'The selected investor was not found.',
            'documents.required' => 'Add at least one document to upload.',
            'documents.*.description.required_with' => 'Provide a description for each uploaded file.',
            'documents.*.document_path.required_with' => 'Attach the document file.',
            'documents.*.document_path.mimes' => 'Documents must be PDF, JPG, or PNG.',
            'documents.*.document_path.max' => 'Each document must be 2MB or less.',
        ];
    }
}

