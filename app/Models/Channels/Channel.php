<?php

namespace App\Models\Channels;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Channel extends Model
{
    use SoftDeletes;

    protected $table = 'channel';

    public $primaryKey = 'channel_id';

    public const STATUS_ACTIVE = 'active';
    public const STATUS_DISABLE = 'disable';

    public const TYPE_CHAT = 'chat';
    public const TYPE_WALL = 'wall';

    protected $fillable = [
        'title', 'slug', 'status', 'type', 'private'
    ];

    protected $dates = [
        'created_at', 'updated_at', 'deleted_at'
    ];

    public static function getStatuses()
    {
        return [
            'active' => self::STATUS_ACTIVE,
            'disable' => self::STATUS_DISABLE
        ];
    }

    public static function getTypes()
    {
        return [
            'chat' => self::TYPE_CHAT,
            'wall' => self::TYPE_WALL
        ];
    }
}
