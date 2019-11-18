<?php

namespace App\Dto;

class Link
{
    /**
     * @var string
     */
    private $url;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $icon;

    /**
     * @var string
     */
    private $base;

    /**
     * @return mixed
     */
    public function getUrl() : string
    {
        return $this->url;
    }

    /**
     * @param $url
     * @return Link
     */
    public function setUrl($url): Link
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle() : string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Link
     */
    public function setTitle(string $title): Link
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription() : string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return Link
     */
    public function setDescription(string $description): Link
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string
     */
    public function getIcon() : string
    {
        return $this->icon;
    }

    /**
     * @param $icon
     * @return Link
     */
    public function setIcon($icon): Link
    {
        $this->icon = $icon;
        return $this;
    }

    /**
     * @return string
     */
    public function getBase() : string
    {
        return $this->base;
    }

    /**
     * @param string $base
     * @return Link
     */
    public function setBase(string $base): Link
    {
        $this->base = $base;
        return $this;
    }

    public static function fromArray($data) : Link{
        $instance = new self;
        $instance
            ->setUrl($data['url'])
            ->setTitle($data['title'])
            ->setDescription($data['description'])
            ->setIcon($data['icon'])
            ->setBase($data['base']);
        return $instance;
    }

}