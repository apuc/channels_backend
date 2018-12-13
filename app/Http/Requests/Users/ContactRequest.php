<?php
/**
 * Created by PhpStorm.
 * User: kirill
 * Date: 05.12.18
 * Time: 17:16
 */

namespace App\Http\Requests\Users;


use App\Models\User\UserContact;
use Doctrine\DBAL\Query\QueryBuilder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ContactRequest extends FormRequest
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
        //dd($this->user_id);
        return [
            'user_id' => [
                'required',
                'integer',
                'exists:users,user_id',
            ],
            'contact_id' => 'required|integer|exists:users,user_id',
            //'status' => 'in:' . implode(',', UserContact::getStatuses()),
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            '*.required' => 'Это поле обязательно',
        ];
    }

}