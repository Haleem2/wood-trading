<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateItemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $itemId = $this->route('item')->id;

        return [
            'code' => [
                'sometimes',
                'string',
                'max:255',
                Rule::unique('items', 'code')->ignore($itemId),
            ],
            'name' => 'sometimes|string|max:255',
            'species' => 'nullable|string|max:255',
            'grade' => 'nullable|string|max:255',
            'thickness' => 'nullable|numeric|min:0',
            'width' => 'nullable|numeric|min:0',
            'length' => 'nullable|numeric|min:0',
            'unit' => 'sometimes|string|max:50',
            'barcode' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('items', 'barcode')->ignore($itemId),
            ],
            'moisture_level' => 'nullable|numeric|min:0|max:100',
            'low_stock_threshold' => 'nullable|numeric|min:0',
            'costing_method' => 'sometimes|in:FIFO,Average',
            'is_active' => 'sometimes|boolean',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'code.unique' => 'The item code has already been taken.',
            'barcode.unique' => 'The barcode has already been taken.',
            'costing_method.in' => 'The costing method must be either FIFO or Average.',
        ];
    }
}
