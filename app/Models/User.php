<?php

namespace App\Models;

use App\Models\Channels\Channel;
use App\Models\Channels\Group;
use App\Models\User\UserContact;
use App\Traits\SlugbleModel;
use Carbon\Carbon;
use DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

/**
 * App\Models\User
 *
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @mixin \Eloquent
 * @property int $user_id
 * @property int $avatar_id
 * @property string $username
 * @property string $email
 * @property string $login
 * @property string|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password', 'login', 'avatar_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [

    ];

    public $primaryKey = 'user_id';


    public function getDate()
    {
        $date = Carbon::now();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function groups()
    {
        return $this->hasMany(Group::class, 'owner_id', 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function channels()
    {
        return $this->belongsToMany(
            Channel::class,
            'channel_users',
            'user_id',
            'channel_id'
        );
    }

    /**
     * Return public name of user
     *
     * @return string
     */
    public function getName()
    {
        return $this->username;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function avatar()
    {
        return $this->hasOne(Avatar::class, 'avatar_id', 'avatar_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function userContacts()
    {
        return $this->hasMany(UserContact::class, 'user_id', 'user_id');
    }

    /**
     * Получение заявок
     *
     * @return $this
     */
    public function senders()
    {
        return $this->belongsToMany(User::class, 'user_contact', 'contact_id', 'user_id')
            ->where(['user_contact.status' => UserContact::REQUEST_SENT]);
    }

    /**
     * select contacts.* from users
     * left join user_contacts on users.id=user_contacts.user_id or users.id=user_contacts.contact_id
     * left join users contacts on user_contacts.user_id = contacts.id or user_contacts.contact_id = contacts.id
     * where (user_contacts.user_id=7 or user_contacts.contact_id=7) and contacts.id <> 7 and  status=1 group by contacts.id
     */
    public function contacts()
    {
        return $this->newQuery()->select('contacts.*')
            ->leftJoin('user_contact', function ($leftJoin) {
                $leftJoin->on('users.user_id', '=', 'user_contact.user_id')
                    ->on('users.user_id', '=', 'user_contact.contact_id', 'or', true);
            })
            ->leftJoin(DB::raw('users contacts'), function ($leftJoin) {
                $leftJoin->on('user_contact.user_id', '=', 'contacts.user_id')
                    ->on('user_contact.contact_id', '=', 'contacts.user_id', 'or', true);
            })
            ->where(function ($query) {
                return $query->where(['user_contact.user_id' => $this->user_id])
                    ->orWhere(['user_contact.contact_id' => $this->user_id]);
            })
            ->where('contacts.user_id', '<>', $this->user_id)
            ->where(['status' => UserContact::REQUEST_ACCEPTED])
            ->orderBy('contacts.user_id')
            ->groupBy('contacts.user_id')->get()->pluck('user_id');
    }

    /**
     * @param array $credentials
     * @return User|null
     */
    public function fetchUserByCredentials(array $credentials)
    {
        if (!isset($credentials['id'])) {
            return null;
        }

        return self::findOrFail($credentials['id']);
    }
}
