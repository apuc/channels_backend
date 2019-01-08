<?php

namespace App\Models\Traits;

/**
 * Трейт для сущности типа канал
 */
trait ChanelEntityTrait
{

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return int
     */
    public function getOwnerId()
    {
        return $this->owner_id;
    }

    /**
     * @return int
     */
    public function getAvatarId()
    {
        return $this->avatar_id;
    }

}