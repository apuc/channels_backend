<?php
/**
 * Created by PhpStorm.
 * User: kirill
 * Date: 11.12.18
 * Time: 15:26
 */

namespace App\Traits;


trait Sluggable
{

    public function findOrFail($data)
    {
        if(is_numeric($data)){
            return $this->model::where([$this->model->primaryKey => $data])->firstOrFail();
        }else{
            return $this->model::where([$this->model->getSlugFieldName() => $data])->firstOrFail();
        }
    }

}
