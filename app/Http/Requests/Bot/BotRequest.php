<?php

namespace App\Http\Requests\Bot;

use App\Models\Channels\Attachment;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class AttachmentRequest.
 *
 * @package App\Http\Requests\Channels
 *
 * @property string $options
 * @property string $status
 * @property string $type
 * @property integer $message_id
 */
class BotRequest extends FormRequest
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
            'owner_id' => 'required|integer',
            'name' => 'required|string',
            'avatar' => 'integer|exists:avatars,avatar_id|nullable',
            'webhook' => 'url|nullable',
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
            '*.required' => 'Это поле обязательно',
        ];
    }
}
