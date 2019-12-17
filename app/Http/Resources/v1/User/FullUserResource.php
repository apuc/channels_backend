<?php
namespace App\Http\Resources\v1\User;


use App\Traits\Avatar;
use Illuminate\Http\Resources\Json\JsonResource;

class FullUserResource extends JsonResource
{
    use Avatar;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'user_id' => $this->user_id,
            'email' => $this->email,
            'username' => $this->getName(),
            'avatar' => $this->getAvatar($this->avatar),
            'is_bot' => $this->isBot()
        ];
    }

}
