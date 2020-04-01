<?php


namespace App\Http\Requests\Api\v1\Auth;


use Illuminate\Foundation\Http\FormRequest;

class PasswordResetRequest extends FormRequest
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
            'email' => 'required|string|max:255|min:3|email|exists:users',
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
          'email.exists' => 'Аккаунт с таким email не зарегестрирован!',
          '*.required' => 'Поле обязательно для заполнения!'
        ];
    }
}
