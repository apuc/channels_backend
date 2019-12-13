<?php

namespace App\Http\Requests\Bot;

use App\Models\Channels\Attachment;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class BotMessageRequest
 * @package App\Http\Requests\Bot
 */
class BotMessageRequest extends FormRequest
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
            'bot_id' => 'required|integer|exists:users,user_id',
            'channel_id' => 'required|integer',
            'message' => 'required',
        ];;
    }

    /**
     * Get the error messages for validation rules
     *
     * @return array
     */
    public function messages()
    {
        return [
            'bot_id.required' => 'bot_id is required!',
            'channel_id.required' => 'channel_id is required!',
            'message.required' => 'message text is required!',
        ];
    }
}
