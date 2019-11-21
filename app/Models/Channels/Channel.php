<?php

namespace App\Models\Channels;

use App\Models\Avatar;
use App\Models\Contracts\ChannelEntityInterface;
use App\Models\Integrations\Integration;
use App\Models\Traits\ChanelEntityTrait;
use App\Models\User;
use App\Traits\SluggableModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

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

    public const PUBLIC_CHANNEL = 0;
    public const PRIVATE_CHANNEL = 1;

    public const TYPE_CHAT = 'chat';
    public const TYPE_WALL = 'wall';
    public const TYPE_DIALOG = 'dialog';

    protected $fillable = [
        'title', 'slug', 'status', 'type', 'private', 'avatar_id', 'owner_id', 'to_id'
    ];

    protected $dates = [
        'created_at', 'updated_at', 'deleted_at'
    ];

    /**
     * Статусы
     * @return array
     */
    public static function getStatuses()
    {
        return [
            'active' => self::STATUS_ACTIVE,
            'disable' => self::STATUS_DISABLE
        ];
    }

    /**
     * Типы
     * @return array
     */
    public static function getTypes()
    {
        return [
            'chat' => self::TYPE_CHAT,
            'wall' => self::TYPE_WALL,
            'dialog' => self::TYPE_DIALOG
        ];
    }

    /**
     * Пользователи канала
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(
            User::class,
            'channels_group_users',
            'channel_id',
            'user_id'
        );
    }

    /**
     * Сообщения канала
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
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
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function owner()
    {
        return $this->hasOne(User::class, 'user_id', 'owner_id');
    }

    /**
     * Для диалогов. Получает пользователя с которым диалог
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function toUser()
    {
        return $this->hasOne(User::class, 'user_id', 'owner_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function integrations()
    {
        return $this->belongsToMany(
            Integration::class,
            'integrations_channels',
            'channel_id',
            'integration_id'
        );
    }

    /**
     * @return bool
     */
    public function isPrivate()
    {
        return $this->private;
    }

    /**
     * @return bool
     */
    public function isDialog()
    {
        return $this->type == self::TYPE_DIALOG;
    }

    /**
     * @return int
     */
    public function getUserCount()
    {
        return $this->users()->count();
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
     * Заголовок канала
     * @return string
     */
    public function getTitle()
    {
        if($this->isDialog()){
          return \Auth::id() == $this->owner_id ? $this->toUser->username : $this->owner->username;
        }

        return $this->title;
    }

    /**
     * @return int
     */
    public function getCount()
    {
        return $this->getUserCount();
    }

}
