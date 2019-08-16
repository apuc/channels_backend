<?php

namespace App\Http\Requests\Channels;

use Illuminate\Foundation\Http\FormRequest;

class IntegrationTypeRequest extends FormRequest
{

//    public $headers = ['Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjRlYTBlYjliYWYwNGY3ODVjMzQzNjI4OTA4NTNiYTJlNTBmMjQwZmZjOTIzMGJlZmJhYzlhZDEwMjk5Y2FmZTA4NmMzNTlkNTIwZjFjZmE1In0.eyJhdWQiOiIyIiwianRpIjoiNGVhMGViOWJhZjA0Zjc4NWMzNDM2Mjg5MDg1M2JhMmU1MGYyNDBmZmM5MjMwYmVmYmFjOWFkMTAyOTljYWZlMDg2YzM1OWQ1MjBmMWNmYTUiLCJpYXQiOjE1NjU5NDI4NzAsIm5iZiI6MTU2NTk0Mjg3MCwiZXhwIjoxNTY2MjAyMDcwLCJzdWIiOiIyMSIsInNjb3BlcyI6W119.LNumTJ2HopS813wtDWXWoxa4rk6xJEa0ilFI-J9Y-9RwNDvHXqbiBmkUnR3g_NKmsn31JqHx3GtbS9Fu8d-k6cpqVEYm6-OUBi4JEPEEKCtfWR1Qf5azsHbAyi_RdGKRlNsYO1Ao6HTSH2Mmj6gcDzlI26bBUabhg3sU67HpB00L0-g2jTvT_0J0ctsukSglb9wn6MauhvyqDXe3rpa8MlRHj4_l7EWk2kieLIOlVxdIvw71X7c60JzRdFCbI1ULZoFspWYJDPc3C90zXSmQnpbFkYQIRCBA-BbCZX53uv0YKGW0kscAfJf6CqnQYcziqZJONXsN3QPzFFitfP7l3xAYcnmCeS5SiFy37YP-7hg3vjCRWGwLvx2XcKmecdnJ-izBu60gUDhc_nOgTkepab2810hdZyjmk1WxHeBN9ouBACtD4UDuKIfgYqJQe8AzwZchmxo0ERaJyAlvcfP73NJPX1rpPOeZDdNi--22bHWBAAbmvQdCblg-bU0DtsppC15wY_HJvyxnwYTlMPoeXpzQJeQvsn-RtivYmW8eOLMz2t805qeGj4YbyB8FVwnJpEKw77FM5dbZgnxi1rh1vDeXkGZQXqJnBs1JQG32RLlioc9qlCMM5ju8nU5W4-wRBMUoJ3J_ZDbAk7-AHhrYnU4ks-o_H0cNg5QFravMW58'];

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
        return [
            'title' => 'required|string|max:255|min:3',
            'slug' => 'required|string|max:255|min:3',
            'fields' => 'required|json',
            'options' => 'required|json',
        ];
    }

    public function messages()
    {
        return [
            '*.required' => 'Это поле обязательно'
        ];
    }

}
