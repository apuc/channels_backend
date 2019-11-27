<?php

namespace App\Models\Channels;

use Illuminate\Database\Eloquent\Model;

class IntegrationType extends Model
{
    /**
     * @inherit doc
     */
    protected $table = 'integration_types';

    /**
     * @inherit doc
     */
    public $timestamps = false;

    /**
     * @inherit doc
     */
    protected $guarded = ['id'];

}
