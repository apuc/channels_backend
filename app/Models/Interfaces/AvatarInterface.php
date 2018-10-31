<?php
/**
 * Created by PhpStorm.
 * User: kirill
 * Date: 31.10.18
 * Time: 17:05
 */

namespace App\Models\Interfaces;


interface AvatarInterface
{

    public function getOrigin();

    public function getAverage();

    public function getSmall();

    public function getId();

}