<?php

namespace App\Models\Integrations;

use App\Models\Channels\Channel;
use App\Models\Integrations\IntegrationType;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Integration extends Model
{
    public $timestamps = false;

    protected $table = 'integrations';

    protected $guarded = ['id'];

    protected $with = ['type'];

    protected $casts = [
      'fields' => 'array',
    ];

    /**
     * Каналы в которых есть эта интеграция
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function channels()
    {
        return $this->belongsToMany(
            Channel::class,
            'integrations_channels',
            'integration_id',
            'channel_id'
        )->withPivot('data');
    }

    /**
     * Тип интеграции
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type()
    {
        return $this->belongsTo(
            IntegrationType::class,
            'type_id',
            'id'
        );
    }
}
