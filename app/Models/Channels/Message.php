<?php

namespace App\Models\Channels;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Message
 * @package App\Models\Channels
 * @property integer $from
 * @property integer $to
 * @property integer $read
 * @property string $text
 */
class Message extends Model
{
    use SoftDeletes;

    /**
     * @inheritdoc
     */
    protected $table = 'message';

    /**
     * @inheritdoc
     */
    public $primaryKey = 'message_id';

    public const STATUS_ACTIVE = 'active';
    public const STATUS_DISABLE = 'disable';

    public const MESSAGE_READ = 1;
    public const MESSAGE_UNREAD = 0;

    /**
     * Сообщений на странице
     */
    public const MESSAGES_PER_PAGE = 20;

    /**
     * @inheritdoc
     */
    protected $fillable = [
        'from', 'to', 'text', 'read', 'channel_id'
    ];

    /**
     * @inheritdoc
     */
    protected $dates = [
        'created_at', 'updated_at', 'deleted_at'
    ];

    /**
     * Прочитано или нет
     * @return int
     */
    public function isRead()
    {
        return $this->read;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function channel()
    {
        return $this->belongsTo(Channel::class, 'channel_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function toUser()
    {
        return $this->belongsTo(User::class, 'to');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function fromUser()
    {
        return $this->belongsTo(User::class, 'from');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function attachments()
    {
        return $this->hasMany(Attachment::class,'message_id');
    }

    public function users()
    {
        return $this->belongsToMany(
            User::class,
            'message_user',
            'message_id',
            'user_id',
            'from',
            'user_id'
        );
    }

}
