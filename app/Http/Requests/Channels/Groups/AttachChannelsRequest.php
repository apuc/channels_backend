<?php

namespace App\Http\Requests\Channels\Groups;

use Illuminate\Foundation\Http\FormRequest;

class AttachChannelsRequest extends FormRequest
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
            'channel_ids' => 'required|array',
            'channel_ids.*' => 'exists:channel,channel_id'
        ];
    }
}
