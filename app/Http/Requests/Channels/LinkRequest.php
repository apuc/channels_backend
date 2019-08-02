<?php

namespace App\Http\Requests\Channels;

use Illuminate\Foundation\Http\FormRequest;

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


}