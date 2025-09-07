<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class CreateInvoice extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'response' => 'validation',
                'errors' => $validator->errors(),
            ], 422)
        );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'invoice_number' => 'required|string|max:255',
            'vendor_id' => 'required|integer|exists:vendors,id',
            'doc_date' => 'required|date',
            'ammount' => 'required|min:0',
            'due_date' => 'nullable|date|after_or_equal:doc_date',
            'status' => 'nullable|string|in:pending,paid'
        ];
    }
}
