<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Avatar extends Model
{
    protected $table = 'avatars';

    public $primaryKey = 'avatar_id';

    public const STATUS_ACTIVE = 'active';
    public const STATUS_DISABLE = 'disable';

    public const SIZE_AVERAGE = 400;
    public const SIZE_SMALL = 150;

    protected $fillable = [
        'original', 'average', 'small', 'status'
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
}
