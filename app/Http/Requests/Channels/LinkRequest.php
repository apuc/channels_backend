<?php

namespace App\Http\Requests\Channels;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class LinkRequest extends FormRequest
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
	    if(\Request::route()->getName() == 'v1.single-link'){
		    $link_rule = 'required|regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/';
	    } else{
		    $link_rule = 'required|regex:/^.*(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?.*$/';
		}

        return [
            'link' => $link_rule
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

    /**
     * Статус 200 чтобы на фронте не сыпало рошибки в консоль
     * @param Validator $validator
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors()->all(), 200));
    }
}
