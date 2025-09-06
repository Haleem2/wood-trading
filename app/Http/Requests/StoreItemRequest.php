<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreItemRequest extends FormRequest
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
        return [
            'code' => 'required|string|max:255|unique:items,code',
            'name' => 'required|string|max:255',
            'species' => 'nullable|string|max:255',
            'grade' => 'nullable|string|max:255',
            'thickness' => 'nullable|numeric|min:0',
            'width' => 'nullable|numeric|min:0',
            'length' => 'nullable|numeric|min:0',
            'unit' => 'required|string|max:50',
            'barcode' => 'nullable|string|max:255|unique:items,barcode',
            'moisture_level' => 'nullable|numeric|min:0|max:100',
            'low_stock_threshold' => 'nullable|numeric|min:0',
            'costing_method' => 'required|in:FIFO,Average',
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
