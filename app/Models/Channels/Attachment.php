<?php

namespace App\Models\Channels;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Attachment.
 *
 * @package App\Models\Channels
 */
class Attachment extends Model
{
    /**
     * @var string
     */
    protected $table = 'attachment';

    /**
     * @var string
     */
    public $primaryKey = 'attachment_id';

    public const STATUS_ACTIVE = 'active';
    public const STATUS_DISABLE = 'disable';

    public const TYPE_FILE = 'file';
    public const TYPE_IMAGE = 'image';

    /**
     * @var array
     */
    protected $fillable = [
        'type', 'message_id', 'status', 'options',
    ];

    /**
     * @var array
     */
    protected $dates = [
        'created_at', 'updated_at'
    ];

    /**
     * @return array
     */
    public static function getStatuses(): array
    {
        return [
            'active' => self::STATUS_ACTIVE,
            'disable' => self::STATUS_DISABLE
        ];
    }

    /**
     * @return array
     */
    public static function getTypes(): array
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
