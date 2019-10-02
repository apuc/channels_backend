<?php

namespace App\Models\Integrations;

use Illuminate\Database\Eloquent\Model;

class Integration extends Model
{
    public $timestamps = false;

    protected $table = 'integrations';

    protected $guarded = ['id'];

    protected $casts = [
      'fields' => 'array',
    ];
}
