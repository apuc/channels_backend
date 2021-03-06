<?php

namespace App\Http\Requests;

use App\Models\Channels\Channel;
use Illuminate\Foundation\Http\FormRequest;

class ChannelRequest extends FormRequest
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
            'title' => 'required|string|max:255|min:3',
            'slug' => 'required|string|max:255|min:3',
            'status' => 'required|in:' . implode(',', Channel::getStatuses()),
            'type' => 'required|in:' . implode(',', Channel::getTypes()),
            'private' => 'required|in:0,1',
            'avatar' => 'integer|exists:avatars,avatar_id|nullable',
        ];
    }

    public function messages()
    {
        return [
            '*.required' => 'Это поле обязательно'
        ];
    }
}
