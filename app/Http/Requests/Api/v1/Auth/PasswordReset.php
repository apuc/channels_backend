<?php


namespace App\Http\Requests\Api\v1\Auth;


use Illuminate\Foundation\Http\FormRequest;

class PasswordReset extends FormRequest
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
            'password' => 'required|string|max:255|min:3',
            'reset_token' => 'required|string|exists:users',
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'reset_token.exists' => 'Не найден пользователь для восстановления пароля!',
            '*.required' => 'Поле обязательно для заполнения!'
        ];
    }
}
