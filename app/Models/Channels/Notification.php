<?php

namespace App\Models\Channels;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    public const STATUS_READ = 1;
    public const STATUS_NOT_READ = 0;

    public const RABBIT_QUEUE_NAME = 'notifications_queue';

    /**
     * {@inheritdoc}
     */
    protected $table = 'notification';

    /**
     * {@inheritdoc}
     */
    public $primaryKey = 'notification_id';

    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'content', 'channel_id','message_id',
    ];

    /**
     * {@inheritdoc}
     */
    protected $dates = [
        'created_at', 'updated_at'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function channel()
    {
        return $this->belongsTo(Channel::class,'channel_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(
            Notification::class,
            'notifications_users',
            'notification_id',
            'user_id'
        );
    }
}
