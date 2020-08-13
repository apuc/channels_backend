<?php

namespace App\Models\Channels;

use App\Models\Avatar;
use App\Models\Contracts\ChannelEntityInterface;
use App\Models\Integrations\Integration;
use App\Models\Meeting;
use App\Models\Traits\ChanelEntityTrait;
use App\Models\User;
use App\Traits\SluggableModel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Class Channel
 * @package App\Models\Channels
 * @property int $channel_id
 * @property string $title
 * @property string $type
 * @property string $slug
 * @property string $status
 * @property boolean $private
 * @property integer $owner_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property Collection $users
 * @property Collection $integrations
 * @property Collection $bots
 * @property Collection $messages
 * @property Collection $activeMeetings
 * @property Collection $unread
 * @property Avatar $avatar
 * @property User $owner
 * @property User $toUser
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
     * Пользователи канала (включая ботов)
     * @return BelongsToMany
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
     * Боты канала
     * @return BelongsToMany
     */
    public function bots()
    {
        return $this->belongsToMany(
            User::class,
            'channels_group_users',
            'channel_id',
            'user_id'
        )->where('is_bot', '=', User::BOT);
    }

    /**
     * Сообщения канала
     * @return HasMany
     */
    public function messages()
    {
        return $this->hasMany(Message::class, 'channel_id', 'channel_id');
    }

    /**
     * @return BelongsTo|HasOne
     */
    public function avatar()
    {
        if($this->isDialog()){
            return auth('api')->id() == $this->owner_id
                ? $this->toUser->avatar()
                : $this->owner->avatar();
        }

        return $this->belongsTo(Avatar::class, 'avatar_id');
    }

    /**
     * @return HasOne
     */
    public function owner()
    {
        return $this->hasOne(User::class, 'user_id', 'owner_id');
    }

    /**
     * Для диалогов. Получает пользователя с которым диалог
     *
     * @return HasOne
     */
    public function toUser()
    {
        return $this->hasOne(User::class, 'user_id', 'to_id');
    }

    /**
     * @return BelongsToMany
     */
    public function integrations()
    {
        return $this->belongsToMany(
            Integration::class,
            'integrations_channels',
            'channel_id',
            'integration_id'
        )->withPivot('data');
    }

    /**
     * Конференции канала
     * @return HasMany
     */
    public function activeMeetings()
    {
        return $this->hasMany(
            Meeting::class,
            'channel_id',
            'channel_id'
        )->where('created_at', '>', Carbon::yesterday());
    }

    /**
     * Непрочитаные сообщения в канале(для текущего юзера)
     *
     */
    public function unread()
    {
        if ($this->isDialog() ) {
            return $this->hasMany(
                Message::class,
                'channel_id',
                'channel_id'
            )->where([
                ['from', '<>', Auth::id()],
                ['read', Message::MESSAGE_UNREAD],
            ]);
        }

        return $this->belongsToMany(
            Message::class,
            'message_user',
            'channel_id',
            'message_id'
        )->wherePivot('user_id', '=', Auth::id());
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
        if ( $this->isDialog() ) {
            return auth('api')->id() == $this->owner_id
                ? $this->toUser->username
                : $this->owner->username;
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

    /**
     * Имя дефолтного бота канала
     * @return string
     */
    public function getDefaultBotName()
    {
        return strtolower(str_replace(' ', '_', $this->title)) . '_bot';
    }

}
