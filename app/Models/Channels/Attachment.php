<?php

namespace App\Models\Channels;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    protected $table = 'attachment';

    public $primaryKey = 'attachment_id';

    public const STATUS_ACTIVE = 'active';
    public const STATUS_DISABLE = 'disable';

    public const TYPE_FILE = 'file';
    public const TYPE_IMAGE = 'image';

    protected $fillable = [
        'type', 'message_id', 'status', 'options'
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

    public static function getTypes()
    {
        return [
            'file' => self::TYPE_FILE,
            'image' => self::TYPE_IMAGE,
        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function message()
    {
        return $this->belongsTo(Message::class,'message_id');
    }
}
