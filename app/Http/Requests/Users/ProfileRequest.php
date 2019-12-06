<?php
namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
            'username' => 'string|max:255|min:3',
            'avatar_id' => 'integer|exists:avatars,avatar_id|nullable'
        ];
    }
}
