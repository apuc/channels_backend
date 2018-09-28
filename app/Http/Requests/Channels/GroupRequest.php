<?php

namespace App\Http\Requests\Channels;

use App\Models\Channels\Group;
use Illuminate\Foundation\Http\FormRequest;

class GroupRequest extends FormRequest
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
            'status' => 'required|in:' . implode(',', Group::getStatuses()),
            'user_ids' => 'array|required',
            'user_ids.*' => 'exists:users,user_id'
        ];
    }

    public function messages()
    {
        return [
            '*.required' => 'Это поле обязательно',
            'user_ids.array' => 'Должен быть массив',
            'user_ids.*.exists' => 'Запись не найдена'
        ];
    }
}
