<?php

namespace App\Http\Requests\Channels;

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
class AddIntegrationRequest extends FormRequest
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
            'integration_id' => 'required',
            'data' => 'required',
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
            '*.required' => 'Это поле обязательно'
        ];
    }
}
