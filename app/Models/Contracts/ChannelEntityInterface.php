<?php

namespace App\Models\Contracts;

/**
 * Интерфейс для сущностей типа каналы и группы
 */
interface ChannelEntityInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @return string
     */
    public function getTitle();

    /**
     * @return string
     */
    public function getSlug();

    /**
     * @return string
     */
    public function getType();

    /**
     * @return int
     */
    public function getOwnerId();

    /**
     * @return int
     */
    public function getAvatarId();

    /**
     * @return int
     */
    public function getCount();

}