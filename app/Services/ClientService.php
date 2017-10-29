<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Models\Client;
use App\Repositories\ClientRepository;
use App\Exceptions\InternalServerErrorHttpException;

class ClientService
{
    private $clientRepository;

    public function __construct(ClientRepository $clientRepository)
    {
        $this->clientRepository = $clientRepository;
    }

    public function create(array $data): Client
    {
        DB::beginTransaction();
        try {
            $client = $this->clientRepository->create($data);

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            throw new InternalServerErrorHttpException('Error while adding record');
        }

        return $client;
    }

    public function update(Client $client, array $data): Client
    {
        DB::beginTransaction();
        try {
            $client = $this->clientRepository->update($client, $data);

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            throw new InternalServerErrorHttpException('Error while updating record');
        }

        return $client;
    }

    public function attachLabels(Client $client, array $data)
    {
        DB::beginTransaction();
        try {
            $this->clientRepository->attachLabels($client, $data);

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            throw new InternalServerErrorHttpException('Error while attaching labels');
        }
    }

    public function attachMeetings(Client $client, array $data)
    {
        DB::beginTransaction();
        try {
            $this->clientRepository->attachMeetings($client, $data);

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            throw new InternalServerErrorHttpException('Error while attaching meetings');
        }
    }

    public function delete(Client $client)
    {
        $this->clientRepository->delete($client);
    }

    public function getById(int $id): Client
    {
        $client = $this->clientRepository->getById($id);

        if (!$client) {
            throw new NotFoundHttpException("Client with id '$id' not found");
        }

        return $client;
    }


}
