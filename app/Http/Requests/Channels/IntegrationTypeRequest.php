<?php

namespace App\Http\Requests\Channels;

use Illuminate\Foundation\Http\FormRequest;

class IntegrationTypeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        //костыль чтобы casts не энкодил json еще раз потому что в реквесте уже и так json приходит
        $this->fields = json_decode($this->fields);
        $this->options = json_decode($this->options);

        return [
            'title' => 'required|string|max:255|min:3',
            'slug' => 'required|string|max:255|min:3',
            'fields' => 'json',
            'options' => 'json',
            'rss_url'=>'required_with:is_rss|url|nullable'
        ];
    }

    public function messages()
    {
        return [
            '*.required' => 'Это поле обязательно',
            'rss_url.required_with' => 'Укажите url для прсинга rss!'
        ];
    }

}
