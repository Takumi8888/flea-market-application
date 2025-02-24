<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'email'    => ['required', 'email', 'failed'],
            'password' => ['required'],
        ];
    }

    public function attributes(): array
    {
        return [
            'email'    => 'メールアドレス',
            'password' => 'パスワード',
        ];
    }

    public function messages(): array
    {
        return [
            'email.required'    => ':attributeを入力してください',
            'email.email'       => ':attributeは「ユーザー名@ドメイン」形式で入力してください',
            'email.failed'      => 'ログイン情報が登録されていません',
            'password.required' => ':attributeを入力してください',
        ];
    }
}
