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
            return null;
        }

        return [
            'id' => $avatar->getId(),
            'origin' => $avatar->getOrigin(),
            'average' => $avatar->getAverage(),
            'small' => $avatar->getSmall(),
        ];

    }

}
