<?php

namespace App\Services;

use App\Http\Requests\Api\v1\MeetingRequest;
use App\Models\Meeting;
use App\Repositories\MeetingRepository;

/**
 * Class MeetingService
 * @package App\Services
 */
class MeetingService
{
    /**
     * @var MeetingRepository
     */
    private $repository;

    /**
     * MeetingService constructor.
     * @param MeetingRepository $repository
     */
    public function __construct(MeetingRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return MeetingRepository
     */
    public function getRepository(): MeetingRepository
    {
        return $this->repository;
    }

    /**
     * @param MeetingRequest $data
     * @return Meeting
     */
    public function createMeeting(MeetingRequest $data): Meeting
    {
        $data->merge(['token' => sha1(time())]);
        return $this->repository->create($data);
    }
}
