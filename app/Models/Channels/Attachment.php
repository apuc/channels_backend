<?php

namespace App\Models\Channels;

use http\Exception\RuntimeException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Class Attachment.
 *
 * @package App\Models\Channels
 */
class Attachment extends Model
{
    /**
     * {@inheritdoc}
     */
    protected $table = 'attachment';

    /**
     * {@inheritdoc}
     */
    public $primaryKey = 'attachment_id';

    public const STATUS_ACTIVE = 'active';
    public const STATUS_DISABLE = 'disable';

    public const TYPE_DOCUMENT = 'document';
    public const TYPE_IMAGE = 'image';
    public const TYPE_ARCHIVE = 'archive';

    private $mimeTypes = [
        self::TYPE_DOCUMENT=>['vnd.openxmlformats-officedocument.wordprocessingml.document'],
        self::TYPE_IMAGE=>['png','gif','jpg','jpeg'],
        self::TYPE_ARCHIVE=>['zip','x-7z','x-xz'],
    ];

    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'type', 'message_id', 'status', 'options',
    ];

    /**
     * {@inheritdoc}
     */
    protected $dates = [
        'created_at', 'updated_at'
    ];

    /**
     * @var array
     */
    public $casts = [
      'options'=>'array'
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
     * Определяет тип аттачмента по mime type файла
     * @return string
     */
    public function getTypeByMime(): string
    {
        if(!isset($this->options['mimeType'])){
            throw new HttpException(500,'Get type error: No mime type in attachment options!');
        }

        $attachmentType = null;

        foreach ($this->mimeTypes as $type=>$mimes){
            if(in_array(explode('/',$this->options['mimeType'])[1],$mimes)){
                $attachmentType = $type;
            }
        }

        return $attachmentType ?: self::TYPE_DOCUMENT;
    }

    /**
     * Устогавливает тип
     * @param string|null $type
     */
    public function setType(string $type = null)
    {
        if($type){
            $this->type = $type;
        }else{
            $this->type = $this->getTypeByMime();
        }
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function message()
    {
        return $this->belongsTo(Message::class,'message_id');
    }
}
