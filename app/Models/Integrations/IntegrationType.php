<?php

namespace App\Models\Integrations;

use Denismitr\JsonAttributes\JsonAttributes;
use Illuminate\Database\Eloquent\Model;

class IntegrationType extends Model
{
    /**
     * @inherit doc
     */
    protected $table = 'integration_types';

    /**
     * @inherit doc
     */
    public $timestamps = false;

    /**
     * @inherit doc
     */
    protected $guarded = ['id'];

    /**
     * @inherit doc
     */
    protected $casts = [
        'user_can_create'=>'bool',
        'fields'=>'array',
        'options'=>'array',
        'settings'=>'array',
    ];

    public function getSettingsAttribute(): JsonAttributes
    {
        return JsonAttributes::create($this, 'settings');
    }

    /**
     * Интеграции этого типа
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function integrations()
    {
        return $this->hasMany(Integration::class,'type_id','id');
    }
}
