<?php

namespace App\Repositories;

use App\Models\Client;
use App\Services\LabelService;
use App\Services\MeetingService;

class ClientRepository
{
    private $labelService;
    private $meetingService;

    public function __construct(LabelService $labelService, MeetingService $meetingService)
    {
        $this->labelService = $labelService;
        $this->meetingService = $meetingService;
    }

    public function create(array $data): Client
    {
        $client = Client::create($data);
        $this->attachLabels($client, $data);

        return $client;
    }

    public function update(Client $client, array $data): Client
    {
        $client->fill($data);
        $client->save();
        $this->attachLabels($client, $data);

        return $client;
    }

    public function attachLabels(Client $client, array $data)
    {
        if (isset($data['labels'])) {
            $client->labels()->sync($data['labels']);
        }

        if (isset($data['new-labels'])) {
            foreach ($data['new-labels'] as $newLabelDesc) {
                $newLabel = $this->labelService->create($newLabelDesc);
                $client->labels()->attach($newLabel->id);
            }
        }
    }

    public function attachMeetings(Client $client, array $data)
    {
        foreach ($data['meetings'] as $plannedFor) {
            $this->meetingService->create(['client_id' => $client->id, 'planned_for' => $plannedFor]);
        }
    }

    public function delete(Client $client)
    {
//        Даже не знаю. Данные же не удаляются, а только помечаются, как удалённые.
//        $client->labels()->detach();
        $client->delete();
    }

    public function getById(int $id)
    {
        return Client::where('id', $id)->first();
    }
}
