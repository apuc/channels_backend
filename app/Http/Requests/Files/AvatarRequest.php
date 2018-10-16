<?php
/**
 * Created by PhpStorm.
 * User: kirill
 * Date: 04.10.18
 * Time: 18:50
 */

namespace App\Http\Requests\Files;


use App\Models\Avatar;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class AvatarRequest
 * @package App\Http\Requests\Files
 * @property string $origin
 * @property string $average
 * @property string $small
 * @property string $status
 */
class AvatarRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

}