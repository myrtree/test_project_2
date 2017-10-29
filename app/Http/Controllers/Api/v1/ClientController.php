<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Client;
use App\Http\Requests\{CreateClientRequest, UpdateClientRequest, AttachLabelsRequest, AttachMeetingsRequest};
use App\Services\ClientService;
use App\Services\MeetingService;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    private $clientService;
    private $meetingService;

    public function __construct(ClientService $clientService, MeetingService $meetingService)
    {
        $this->clientService = $clientService;
        $this->meetingService = $meetingService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = $this->queryByUrlParameters(Client::query());

        return response()->json($result);
    }

    /**
     * @param int $clientId
     */
    public function futureMeetings(int $clientId)
    {
        $client = $this->clientService->getById($clientId);
        $meetings = $this->meetingService->getFutureMeetings($client);

        return response()->json($meetings);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateClientRequest $request)
    {
        $client = $this->clientService->create($request->input());

        return response()->json($client);
    }

    /**
     * @param int $clientId
     * @param AttachLabelsRequest $request
     */
    public function attachLabels(int $clientId, AttachLabelsRequest $request)
    {
        $client = $this->clientService->getById($clientId);
        $this->clientService->attachLabels($client, $request->input());

        return response()->json($client);
    }

    /**
     * @param int $clientId
     * @param Request $request
     */
    public function attachMeetings(int $clientId, AttachMeetingsRequest $request)
    {
        $client = $this->clientService->getById($clientId);
        $this->clientService->attachMeetings($client, $request->input());

        return response()->json($client);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $client = $this->clientService->getById($id);

        return response()->json($client);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateClientRequest $request, $id)
    {
        $client = $this->clientService->getById($id);
        $client = $this->clientService->update($client, $request->input());

        return response()->json($client);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $client = $this->clientService->getById($id);
        $this->clientService->delete($client);
    }
}
