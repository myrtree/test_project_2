<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Meeting;
use App\Services\ClientService;
use App\Services\MeetingService;
use App\Http\Requests\{CreateMeetingRequest, UpdateMeetingRequest};

class MeetingController extends Controller
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
    public function index(int $clientId = null)
    {
        if ($clientId) {
            $client = $this->clientService->getById($clientId);
            $query = $client->meetings()->getQuery();
        } else {
            $query = Meeting::query();
        }

        $result = $this->queryByUrlParameters($query);

        return response()->json($result);
    }

    public function futureMeetings()
    {
        $meetings = $this->meetingService->getFutureMeetings();

        return response()->json($meetings);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateMeetingRequest $request)
    {
        $meeting = $this->meetingService->create($request->only(['client_id', 'planned_for']));

        return response()->json($meeting);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $meeting = $this->meetingService->getById($id);

        return response()->json($meeting);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMeetingRequest $request, $id)
    {
        $meeting = $this->meetingService->getById($id);
        $meeting = $this->meetingService->update($meeting, $request->only(['planned_for']));

        return response()->json($meeting);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $meeting = $this->meetingService->getById($id);
        $this->meetingService->delete($meeting);
    }
}
