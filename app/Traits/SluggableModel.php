<?php
/**
 * Created by PhpStorm.
 * User: kirill
 * Date: 11.12.18
 * Time: 15:56
 */

namespace App\Traits;


trait SluggableModel
{

    public function getSlugFieldName()
    {
        return 'slug';
    }

}