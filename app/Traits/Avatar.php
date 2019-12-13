<?php
/**
 * Created by PhpStorm.
 * User: kirill
 * Date: 31.10.18
 * Time: 17:12
 */

namespace App\Traits;


use App\Models\Interfaces\AvatarInterface;
use Illuminate\Support\Facades\Auth;

trait Avatar
{

    /**
     * @param AvatarInterface|null $avatar
     * @return array|null
     */
    public function getAvatar($avatar)
    {
        if($this->getType() == 'channel' && $this->isDialog()){
            $avatar = Auth::id() == $this->owner_id
                ? $this->toUser->avatar
                : $this->owner->avatar;
        }

        if (!$avatar) {

            $default = ($this->getType() == 'user' && $this->isBot()) ? '/bot_avatar.png' : '/no-avatar.png';

            return [
                'origin' => getenv('FILES_SERVER_URL') . $default,
                'average' => getenv('FILES_SERVER_URL') . $default,
                'small' => getenv('FILES_SERVER_URL') . $default,
            ];
        }

        return [
            'id' => $avatar->getId(),
            'origin' => $avatar->getOrigin(),
            'average' => $avatar->getAverage(),
            'small' => $avatar->getSmall(),
        ];

    }

}
