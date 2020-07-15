<?php


namespace App\Models;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Meeting
 * @package App\Models
 * @property int $id
 * @property int $channel_id
 * @property string $name
 */
class Meeting extends Model
{
    protected $table = 'meetings';
    protected $guarded = ['id'];
}
