<?php

namespace App\Models;

use App\Models\Interfaces\AvatarInterface;
use Illuminate\Database\Eloquent\Model;

class Avatar extends Model implements AvatarInterface
{
    protected $table = 'avatars';

    public $primaryKey = 'avatar_id';

    public const STATUS_ACTIVE = 'active';
    public const STATUS_DISABLE = 'disable';

    public const SIZE_AVERAGE = 400;
    public const SIZE_SMALL = 150;

    protected $fillable = [
        'origin', 'average', 'small', 'status'
    ];

    protected $dates = [
        'created_at', 'updated_at'
    ];

    public static function getStatuses()
    {
        return [
            'active' => self::STATUS_ACTIVE,
            'disable' => self::STATUS_DISABLE
        ];
    }

    public function getOrigin()
    {
        return getenv('FILES_SERVER_URL') . $this->origin;
    }

    public function getAverage()
    {
        return getenv('FILES_SERVER_URL') . $this->average;
    }

    public function getSmall()
    {
        return getenv('FILES_SERVER_URL') . $this->small;
    }

    public function getId()
    {
        return $this->avatar_id;
    }
}
