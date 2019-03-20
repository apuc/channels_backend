<?php

namespace App\Http\Requests\Files;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class AttachmentFileRequest.
 *
 * @package App\Http\Requests\Files
 */
class AttachmentFileRequest extends FormRequest
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

    public function rules()
    {
        return [
            'attachment' => 'required|max:10240'
        ];
    }

}