<?php

namespace App\Models\User;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class UserContact extends Model
{
    protected $table = 'user_contact';

    public $incrementing = false;

    protected $primaryKey = ['user_id', 'contact_id'];

    public const REQUEST_SENT = 'sent';
    public const REQUEST_ACCEPTED = 'accepted';
    public const REQUEST_REJECTED = 'rejected';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'contact_id', 'status'
    ];

    /**
     * Get statuses
     *
     * @return array
     */
    public static function getStatuses()
    {
        return [
            'sent' => self::REQUEST_SENT,
            'accepted' => self::REQUEST_ACCEPTED,
            'rejected' => self::REQUEST_REJECTED,
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function contact()
    {
        return $this->belongsTo(User::class, 'contact_id', 'user_id');
    }

    /**
     * Set the keys for a save update query.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function setKeysForSaveQuery(Builder $query)
    {
        $keys = $this->getKeyName();
        if(!is_array($keys)){
            return parent::setKeysForSaveQuery($query);
        }

        foreach($keys as $keyName){
            $query->where($keyName, '=', $this->getKeyForSaveQuery($keyName));
        }

        return $query;
    }

    /**
     * Get the primary key value for a save query.
     *
     * @param mixed $keyName
     * @return mixed
     */
    protected function getKeyForSaveQuery($keyName = null)
    {
        if(is_null($keyName)){
            $keyName = $this->getKeyName();
        }

        if (isset($this->original[$keyName])) {
            return $this->original[$keyName];
        }

        return $this->getAttribute($keyName);
    }
}
