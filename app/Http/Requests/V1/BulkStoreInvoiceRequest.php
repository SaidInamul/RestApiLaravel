<?php

namespace App\Http\Requests\V1;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class BulkStoreInvoiceRequest extends FormRequest
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
            //
            '*.customer_id' => ['required', 'integer'],
            '*.amount' => ['required', 'numeric'],
            '*.status' => ['required', Rule::in(['P', 'B', 'V', 'p', 'b', 'v'])],
            '*.billed_date' => ['required', 'date_format:Y-m-d H:i:s'],
            '*.paid_date' => [
                'nullable', // This makes it nullable
                'date_format:Y-m-d H:i:s', // Date format validation
                'required_if:*.status,P', // Paid date is required if status is 'P'
                'required_if:*.status,p', // Paid date is required if status is 'p'
            ],
        ];
    }
    
    protected function prepareForValidation (){
        $data = [];

        foreach ($this->toArray() as $job) {
            $data[] = [
                'customer_id' => $job['customerID'] ?? null,
                'amount' => $job['amount'] ?? null,
                'status' => $job['status'] ?? null,
                'billed_date' => $job['billedDate'] ?? null,
                'paid_date' => $job['paidDate'] ?? null,
            ];
        }

        $this->replace($data);
    }
}
