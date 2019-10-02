<?php

namespace App\Models\Integrations;

use Illuminate\Database\Eloquent\Model;

class IntegrationType extends Model
{
    protected $table = 'integration_types';
    public $timestamps = false;

    protected $casts = [
        'user_can_create'=>'bool',
        'fields'=>'array',
        'options'=>'array',
    ];
}
