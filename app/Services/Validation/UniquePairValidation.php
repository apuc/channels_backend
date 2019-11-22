<?php
/**
 * Created by PhpStorm.
 * User: kirill
 * Date: 13.12.18
 * Time: 16:22
 */

namespace App\Services\Validation;


use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Validator;

/**
 * Проверка уникальной пары в таблице
 *
 * Class UniquePairValidation
 * @package App\Services\Validation
 */
class UniquePairValidation extends Validator {

    /**
     * Валидация на уникальную пару значений. Если уже есть запись field1 = 1, field2 =2
     *
     * $attribute Input name
     * $value Input value
     * $parameters Table, field1
     */
    public function validateUniqueWith($attribute, $value, $parameters)
    {
        //Делаем запрос к базе, чтобы проверить есть ли такая запись
        $result = DB::table($parameters[0])->where(function($query) use ($attribute, $value, $parameters) {
            $query->where($attribute, '=', $value)
            ->where($parameters[1], '=', $parameters[2]);
        })->first();

        //если запись существует, возвращаем ошибку валидации
        return $result ? false : true;
    }

    /**
     * Валидация на уникальную пару значений в обе стороны. Если уже есть запись field1 = 1, field2 =2 или field1 = 2, field2 =1
     *
     * @param $attribute
     * @param $value
     * @param $parameters
     * @return bool
     */
    public function validateUniqueWithReverse($attribute, $value, $parameters)
    {
        //Делаем запрос к базе, чтобы проверить есть ли такая запись
        $result = DB::table($parameters[0])->where(function($query) use ($attribute, $value, $parameters) {
            $query->where([
                [$parameters[1], '=', $parameters[3]],
                [$parameters[2], '=', $parameters[4]],
            ])->orWhere([
                [$parameters[1], '=', $parameters[4]],
                [$parameters[2], '=', $parameters[3]],
            ]);
        })->first();

        //если запись существует, возвращаем ошибку валидации
        return $result ? false : true;
    }

}
