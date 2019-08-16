<?php

namespace App\Models\Channels;

use Illuminate\Database\Eloquent\Model;

class IntegrationType extends Model
{
    protected $table = 'integration_types';

    protected $fillable = ['title', 'slug', 'fields', 'options'];

}
