<?php

namespace App\Http\Requests;

use App\Models\Channels\Channel;
use Illuminate\Foundation\Http\FormRequest;

class DialogRequest extends FormRequest
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
            'to_id' => 'required|integer|exists:users,user_id',
            'owner_id' => 'required|integer|exists:users,user_id',
        ];
    }

    public function messages()
    {
        return [
            '*.required' => 'Это поле обязательно'
        ];
    }
}
