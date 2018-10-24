<?php

namespace App\Models\Channels;

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

    protected $table = 'message';

    public $primaryKey = 'message_id';

    public const STATUS_ACTIVE = 'active';
    public const STATUS_DISABLE = 'disable';

    public const TYPE_CHAT = 'chat';
    public const TYPE_WALL = 'wall';
    public const TYPE_DIALOG = 'dialog';

    protected $fillable = [
        'from', 'to', 'text', 'read', 'channel_id'
    ];

    protected $dates = [
        'created_at', 'updated_at', 'deleted_at'
    ];

    public function isRead()
    {
        return $this->read;
    }

}
