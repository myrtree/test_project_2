<?php

namespace App\Repositories;

use Carbon\Carbon;
use App\Models\Client;
use App\Models\Meeting;

class MeetingRepository
{
    public function create(array $data): Meeting
    {
        $meeting = Meeting::create($data);

        return $meeting;
    }

    public function update(Meeting $meeting, array $data): Meeting
    {
        $meeting = $meeting->fill($data);
        $meeting->save();

        return $meeting;
    }

    public function delete(Meeting $meeting)
    {
        $meeting->delete();
    }

    public function getFutureMeetings(Client $client = null)
    {
        if ($client) {
            $query = $client->meetings()->getQuery();
        } else {
            $query = Meeting::query();
        }

        $meetings = $query->where('planned_for', '>=', Carbon::now())
            ->orderBy('planned_for')
            ->get();

        return $meetings;
    }

    public function getById(int $id)
    {
        return Meeting::where('id', $id)->first();
    }
}
