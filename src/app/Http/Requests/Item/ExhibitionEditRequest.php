<?php

namespace App\Http\Requests\Item;

use Illuminate\Foundation\Http\FormRequest;

class ExhibitionEditRequest extends FormRequest
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
            'name'      => ['required', 'string', 'max:50'],
            'brand'     => ['required', 'string', 'max:50'],
            'price'     => ['required', 'min:1'],
            'detail'    => ['required', 'string', 'max:255'],
            'condition' => 'required',
            'category'  => 'required',
        ];
    }

    public function attributes(): array
    {
        return [
            'name'      => '商品名',
            'brand'     => 'ブランド名',
            'price'     => '販売価格',
            'detail'    => '商品の説明',
            'condition' => '商品の状態',
            'category'  => 'カテゴリー'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'      => ':attributeを入力してください',
            'name.string'        => ':attributeには文字を指定してください',
            'name.max'           => ':attributeは:max文字以下で入力してください',
            'brand.required'     => ':attributeを入力してください',
            'brand.string'       => ':attributeには文字を指定してください',
            'brand.max'          => ':attributeは:max文字以下で入力してください',
            'price.required'     => ':attributeを入力してください',
            'price.min'          => ':attributeは:min円以上の金額を入力してください',
            'detail.required'    => ':attributeを入力してください',
            'detail.string'      => ':attributeには文字を指定してください',
            'detail.max'         => ':attributeは:max文字以内で入力してください',
            'condition.required' => ':attributeを選択してください',
            'category.required'  => ':attributeを選択してください',
        ];
    }
}
