<?php
/**
 * Created by PhpStorm.
 * User: kirill
 * Date: 13.12.18
 * Time: 16:21
 */

namespace App\Services\Validation;

use Illuminate\Support\ServiceProvider;

class UniquePairValidationServiceProvider extends ServiceProvider {


    /**
     * Регистрируем service provider.
     *
     * @return void
     */
    public function register()
    {
        //Ничего не нужно регистрировать, оставляем пустым
    }

    /**
     * Загрузка service provider.
     */
    public function boot()
    {
        //Необходимо переопределить валидатор по умолчанию нашим собственным валидатором
        //Для этого используем resolver function
        $this->app->validator->resolver(function ($translator, $data, $rules, $messages)
        {
            // This class will hold all our custom validations
            return new UniquePairValidation($translator, $data, $rules, $messages);
        });
    }

}