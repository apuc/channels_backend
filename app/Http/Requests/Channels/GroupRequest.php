<?php

namespace App\Http\Requests\Channels;

use App\Models\Channels\Group;
use App\Traits\SmartRequest;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\ParameterBag;

/**
 * Class GroupRequest
 * @package App\Http\Requests\Channels
 * @property string $title
 * @property string $slug
 * @property string $status
 * @property integer $avatar_id
 * @property integer $owner_id
 */
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
            'owner_id' => 'required|integer|exists:users,user_id',
            'slug' => 'required|string|max:255|min:3',
            'status' => 'required|in:' . implode(',', Group::getStatuses()),
            'user_ids' => 'array',
            'user_ids.*' => 'exists:users,user_id',
            'avatar' => 'integer|exists:avatars,avatar_id|nullable'
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
