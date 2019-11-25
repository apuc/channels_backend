<?php

namespace App\Http\Requests\Channels\Messages;

use App\Models\Channels\Channel;
use Illuminate\Foundation\Http\FormRequest;

class MarkReadRequest extends FormRequest
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
            'message_ids' => 'required|array',
        ];
    }

    public function messages()
    {
        return [
            '*.required' => 'Это поле обязательно'
        ];
    }
}
