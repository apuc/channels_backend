<?php

namespace App\Http\Requests\Channels;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class MessageRequest
 * @package App\Http\Requests\Channels
 * @property integer $from
 * @property integer $to
 * @property string $text
 * @property integer $read
 * @property integer $channel_id
 */
class MessageRequest extends FormRequest
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
            'channel_id' => 'integer|exists:channel,channel_id|nullable',
            'from' => 'integer|exists:users,user_id|nullable',
            'to' => 'integer|exists:users,user_id|nullable',
            'read' => 'integer',
            'text' => 'string|nullable',
        ];
    }

    public function messages()
    {
        return [
            '*.required' => 'Это поле обязательно'
        ];
    }
}
