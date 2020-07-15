<?php
namespace App\Http\Requests\Api\v1;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class MeetingRequest
 * @package App\Http\Requests\Api\v1
 *
 * @property string $name
 * @property string $token
 * @property int $channel
 */
class MeetingRequest extends FormRequest
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
            'name' => 'required|string',
            'channel' => 'required',
        ];
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
