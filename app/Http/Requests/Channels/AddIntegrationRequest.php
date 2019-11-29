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
        $rules = [
            'integration_id' => [
                'required',
            ],
        ];

        if ($this->method() === 'POST'){
            $rules['integration_id'][] = 'unique_with:integrations_channels,channel_id,' . $this->route('channel');
        }

        return $rules;
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
            'integration_id.unique_with' => 'Эта интеграция уже есть в канале!',
        ];
    }
}
