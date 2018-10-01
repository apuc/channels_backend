<?php

namespace App\Models\Channels;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Channels\Group
 *
 * @mixin \Eloquent
 * @property int $channels_group_id
 * @property string $title
 * @property string $slug
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Group extends Model
{
    use SoftDeletes;

    protected $table = 'channels_group';

    public $primaryKey = 'channels_group_id';

    public const STATUS_ACTIVE = 'active';
    public const STATUS_DISABLE = 'disable';

    protected $fillable = [
        'title', 'slug', 'status'
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

    public function users()
    {
        return $this->belongsToMany(
            User::class,
            'channels_group_users',
            'channels_group_id',
            'user_id'
        );
    }
}
