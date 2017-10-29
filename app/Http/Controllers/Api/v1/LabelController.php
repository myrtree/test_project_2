<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Label;
use App\Services\LabelService;
use App\Services\ClientService;
use App\Http\Requests\{CreateLabelRequest, UpdateLabelRequest};

class LabelController extends Controller
{
    private $labelService;
    private $clientService;

    public function __construct(LabelService $labelService, ClientService $clientService)
    {
        $this->labelService = $labelService;
        $this->clientService = $clientService;
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
            $query = $client->labels()->getQuery();
        } else {
            $query = Label::query();
        }

        $result = $this->queryByUrlParameters($query);

        return response()->json($result);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateLabelRequest $request)
    {
        $data = $request->only(['name', 'color']);
        $label = $this->labelService->create($data);

        return response()->json($label);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $label = $this->labelService->getById($id);

        return response()->json($label);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLabelRequest $request, $id)
    {
        $label = $this->labelService->getById($id);
        $label = $this->labelService->update($label, $request->only(['name', 'color']));

        return response()->json($label);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $label = $this->labelService->getById($id);
        $this->labelService->delete($label);
    }
}
