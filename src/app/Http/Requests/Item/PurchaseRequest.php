<?php

namespace App\Http\Requests\Item;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseRequest extends FormRequest
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
            'purchase' => 'required',
            'address'  => 'required',
        ];
    }

    public function attributes(): array
    {
        return [
            'purchase' => '支払い方法',
            'address'  => '配送先',
        ];
    }

    public function messages(): array
    {
        return [
            'purchase.required' => ':attributeを選択してください',
            'address.required'  => ':attributeを選択してください',
        ];
    }
}
