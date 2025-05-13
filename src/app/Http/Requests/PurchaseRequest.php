<?php

namespace App\Http\Requests;

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
			'payment_method' => 'required',
			'user_postcode'  => 'required',
			'user_address'   => 'required',
			'user_building'  => 'required',
        ];
    }

    public function attributes(): array
    {
        return [
			'payment_method' => '支払い方法',
			'user_postcode'  => '郵便番号',
			'user_address'   => '住所',
			'user_building'  => '建物名',
        ];
    }

    public function messages(): array
    {
        return [
			'payment_method.required' => ':attributeを選択してください',
			'user_postcode.required'  => ':attributeを入力してください',
			'user_address.required'   => ':attributeを入力してください',
			'user_building.required'  => ':attributeを入力してください',
        ];
    }
}
