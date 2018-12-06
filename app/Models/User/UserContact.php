<?php

namespace App\Models\User;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class UserContact extends Model
{
    protected $table = 'user_contact';

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
}
