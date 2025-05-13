<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;

class ProfileRequest extends FormRequest
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
        Validator::extend('postcode', function ($attribute, $value, $parameters, $validator) {
            return preg_match('/^[0-9]{3}-?[0-9]{4}$/', $value);
        });

        return [
            'user_name'     => ['required', 'string', 'max:50'],
			'user_image'    => ['required', 'mimes:jpeg,png'],
			'user_postcode' => ['required', 'postcode', 'min:8'],
			'user_address'  => ['required', 'string', 'max:100'],
			'user_building' => ['required', 'string', 'max:100'],
        ];
    }

    public function attributes(): array
    {
        return [
            'user_name'     => 'ユーザー名',
			'user_image'    => '画像',
			'user_postcode' => '郵便番号',
			'user_address'  => '住所',
			'user_building' => '建物名',
        ];
    }

    public function messages(): array
    {
        return [
            'user_name.required'     => ':attributeを入力してください',
            'user_name.string'       => ':attributeには文字を指定してください',
            'user_name.max'          => ':attributeは:max文字以下で入力してください',
			'user_image.required'    => ':attributeを選択してください',
			'user_image.mimes'       => '拡張子が.jpegもしくは.pngの画像をアップロードしてください',
			'user_postcode.required' => ':attributeを入力してください',
			'user_postcode.postcode' => ':attributeは「〇〇〇－〇〇〇〇」形式で入力してください',
			'user_postcode.min'      => ':attributeは「〇〇〇－〇〇〇〇」形式で入力してください',
			'user_address.required'  => ':attributeを入力してください',
			'user_address.string'    => ':attributeには文字を指定してください',
			'user_address.max'       => ':attributeは:max文字以下で入力してください',
			'user_building.required' => ':attributeを入力してください',
			'user_building.string'   => ':attributeには文字を指定してください',
			'user_building.max'      => ':attributeは:max文字以下で入力してください',
        ];
    }
}
