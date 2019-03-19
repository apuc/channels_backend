<?php

namespace App\Http\Requests\Channels;

use App\Models\Channels\Attachment;
use Illuminate\Foundation\Http\FormRequest;

class AttachmentRequest extends FormRequest
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
            'options' => 'required|json',
            'message_id' => 'required|integer|exists:message,message_id',
            'status' => 'required|in:' . implode(',', Attachment::getStatuses()),
            'type' => 'required|in:' . implode(',', Attachment::getTypes()),
        ];
    }

    public function messages()
    {
        return [
            '*.required' => 'Это поле обязательно'
        ];
    }
}
