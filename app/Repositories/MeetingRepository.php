<?php
namespace App\Repositories;

use App\Http\Requests\Api\v1\MeetingRequest;
use App\Models\Meeting;
use Carbon\Carbon;

/**
 * Class MeetingRepository
 * @package App\Repositories
 */
class MeetingRepository extends BaseRepository
{
    /**
     * MeetingRepository constructor.
     * @param Meeting $model
     */
    public function __construct(Meeting $model)
    {
        $this->model = $model;
    }

    /**
     * @param MeetingRequest $data
     * @return Meeting
     */
    public function create(MeetingRequest $data): Meeting
    {
        $meeting = new Meeting([
            'channel_id' => $data->channel,
            'name' => $data->name,
            'token' => $data->token,
        ]);

        $meeting->save();

        return $meeting;
    }

    public function checkByToken(string $token): ?Meeting
    {
        return $this->model::where('token', $token)
            ->where('created_at', '>',Carbon::yesterday())
            ->first();
    }
}
