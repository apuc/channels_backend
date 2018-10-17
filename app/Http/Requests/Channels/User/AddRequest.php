<?php

namespace App\Http\Requests\Channels\User;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class AddRequest
 * @package App\Http\Requests\Channels\User
 * @property integer $channel_id
 * @property integer $user_id
 */
class AddRequest extends FormRequest
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
            'user_id' => 'required|integer|exists:users,user_id',
            'channel_id' => 'required|integer|exists:channel,channel_id',
        ];
    }

    public function messages()
    {
        return [
            '*.required' => 'Это поле обязательно'
        ];
    }
}
