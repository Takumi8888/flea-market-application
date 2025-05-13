<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MessageRequest extends FormRequest
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
			'message' => ['required', 'string', 'max:400'],
			'image'   => 'mimes:jpeg,png',
		];
	}

	public function attributes(): array
	{
		return [
			'message' => '本文',
			'image'   => '画像',
		];
	}

	public function messages(): array
	{
		return [
			'message.required' => ':attributeを入力してください',
			'message.string'   => ':attributeには文字を指定してください',
			'message.max'      => ':attributeは:max文字以内で入力してください',
			'image.mimes'      => '「.png」または「.jpeg」形式でアップロードしてください',
		];
	}
}
