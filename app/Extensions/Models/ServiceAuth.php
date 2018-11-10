<?php

namespace App\Extensions\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @mixin \Eloquent
 */
class ServiceAuth extends Model
{
    public $table = 'service_auth';

    public $fillable = ['service_id', 'access_token', 'status'];

    public $dates = ['created_at', 'updated_at'];

    public $primaryKey = 'service_id';
    public $incrementing = false;

    public function fetchService($service_id, $service_token)
    {
        $service = self::where(['service_id' => $service_id, 'access_token' => $service_token])->first();

        if ($service) {
            return $service;
        }

        return null;
    }
}
