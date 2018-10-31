<?php
/**
 * Created by PhpStorm.
 * User: kirill
 * Date: 31.10.18
 * Time: 17:12
 */

namespace App\Traits;


use App\Models\Interfaces\AvatarInterface;

trait Avatar
{

    /**
     * @param AvatarInterface|null $avatar
     * @return array|null
     */
    public function getAvatar($avatar)
    {
        if ($avatar) {
            return [
                'avatar_id' => $avatar->getId(),
                'origin' => $avatar->getOrigin(),
                'average' => $avatar->getAverage(),
                'small' => $avatar->getSmall(),
            ];
        }
        return null;
    }

}