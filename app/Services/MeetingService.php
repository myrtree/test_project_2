<?php

namespace App\Services;

use App\Models\Client;
use App\Models\Meeting;
use Carbon\Carbon;
use App\Repositories\MeetingRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class MeetingService
{
    private $meetingRepository;

    public function __construct(MeetingRepository $meetingRepository)
    {
        $this->meetingRepository = $meetingRepository;
    }

    public function create(array $data): Meeting
    {
        $dateTime = new Carbon($data['planned_for']);
        if ($dateTime->lt(Carbon::now())) {
            throw new UnprocessableEntityHttpException('meeting date earlier than now');
        }

        return $this->meetingRepository->create($data);
    }

    public function update(Meeting $meeting, array $data): Meeting
    {
        $dateTime = new Carbon($data['planned_for']);
        if ($dateTime->lt(Carbon::now())) {
            throw new UnprocessableEntityHttpException('meeting date earlier than now');
        }

        return $this->meetingRepository->update($meeting, $data);
    }

    public function getById(int $id): Meeting
    {
        $meeting = $this->meetingRepository->getById($id);

        if (!$meeting) {
            throw new NotFoundHttpException("Meeting with id '$id' not found");
        }

        return $meeting;
    }

    public function getFutureMeetings(Client $client = null)
    {
        return $this->meetingRepository->getFutureMeetings($client);
    }

    public function delete(Meeting $meeting)
    {
        $this->meetingRepository->delete($meeting);
    }
}
