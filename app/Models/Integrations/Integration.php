<?php

namespace App\Models\Integrations;

use App\Models\Channels\Channel;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Integration extends Model
{
    public $timestamps = false;

    protected $table = 'integrations';

    protected $guarded = ['id'];

    protected $casts = [
      'fields' => 'array',
    ];

    public function channels()
    {
        return $this->belongsToMany(
            Channel::class,
            'integrations_channels',
            'integration_id',
            'channel_id'
        );
    }
}
