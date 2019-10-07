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

    /**
     * Интеграции этого типа
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function integrations()
    {
        return $this->hasMany(Integration::class,'type_id','id');
    }
}
