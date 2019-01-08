<?php

namespace App\Models\Channels;

use App\Models\Avatar;
use App\Models\Contracts\ChannelEntityInterface;
use App\Models\Traits\ChanelEntityTrait;
use App\Models\User;
use App\Traits\SluggableModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Channel
 * @package App\Models\Channels
 * @property string $title
 * @property string $slug
 * @property string $status
 * @property boolean $private
 * @property integer $owner_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Channel extends Model implements ChannelEntityInterface
{
    use SoftDeletes, SluggableModel, ChanelEntityTrait;

    protected $table = 'channel';

    public $primaryKey = 'channel_id';

    public const STATUS_ACTIVE = 'active';
    public const STATUS_DISABLE = 'disable';

    public const TYPE_CHAT = 'chat';
    public const TYPE_WALL = 'wall';
    public const TYPE_DIALOG = 'dialog';

    protected $fillable = [
        'title', 'slug', 'status', 'type', 'private', 'avatar_id', 'owner_id'
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
            'wall' => self::TYPE_WALL,
            'dialog' => self::TYPE_DIALOG
        ];
    }

    public function isPrivate()
    {
        return $this->private;
    }

    public function users()
    {
        return $this->belongsToMany(
            User::class,
            'channel_users',
            'channel_id',
            'user_id'
        );
    }

    public function messages()
    {
        return $this->hasMany(Message::class, 'channel_id', 'channel_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function avatar()
    {
        return $this->belongsTo(Avatar::class, 'avatar_id');
    }

    /**
     * @return int
     */
    public function getUserCount()
    {
        return $this->users()->count();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function owner()
    {
        return $this->hasOne(User::class, 'user_id', 'owner_id');
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->channel_id;
    }

    /**
     * Тип сущности
     *
     * @return string
     */
    public function getType()
    {
        return 'channel';
    }

    /**
     * @return int
     */
    public function getCount()
    {
        return $this->getUserCount();
    }

}