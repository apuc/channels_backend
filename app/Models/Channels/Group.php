<?php

namespace App\Models\Channels;

use App\Models\Avatar;
use App\Models\Contracts\ChannelEntityInterface;
use App\Models\Traits\ChanelEntityTrait;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * App\Models\Channels\Group
 *
 * @mixin \Eloquent
 * @property int $channels_group_id
 * @property int $owner_id
 * @property string $title
 * @property string $slug
 * @property string $status
 * @property Carbon|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class Group extends Model implements ChannelEntityInterface
{
    use SoftDeletes, ChanelEntityTrait;

    protected $table = 'channels_group';

    public $primaryKey = 'channels_group_id';

    public const STATUS_ACTIVE = 'active';
    public const STATUS_DISABLE = 'disable';

    protected $fillable = [
        'title', 'slug', 'status', 'avatar_id', 'owner_id'
    ];

    protected $dates = [
        'created_at', 'updated_at', 'deleted_at'
    ];

    protected $with = ['avatar'];

    public static function getStatuses()
    {
        return [
            'active' => self::STATUS_ACTIVE,
            'disable' => self::STATUS_DISABLE
        ];
    }

    /**
     * @return BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(
            User::class,
            'channels_group_users',
            'channels_group_id',
            'user_id'
        );
    }

    /**
     * @return BelongsToMany
     */
    public function channels()
    {
        return $this->belongsToMany(
            Channel::class,
            'channels_group_users',
            'channels_group_id',
            'channel_id'
        );
    }

    /**
     * @return HasOne
     */
    public function avatar()
    {
        return $this->hasOne(Avatar::class, 'avatar_id', 'avatar_id');
    }

    /**
     * @return HasOne
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
        return $this->channels_group_id;
    }

    /**
     * Тип сущности
     *
     * @return string
     */
    public function getType()
    {
        return 'group';
    }

    /**
     * @return int
     */
    public function getCount()
    {
        return $this->channels()->count();
    }
}
