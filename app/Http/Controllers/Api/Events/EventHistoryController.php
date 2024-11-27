<?php

namespace App\Http\Controllers\Api\Events;

use App\Http\Controllers\Controller;
use App\Http\Requests\Events\EventHistoryRequest;
use App\Models\Event;
use App\Models\EventHistory;

class EventHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::whereHas('histories' , function ($query) {
            $query->where('going', 1);
        })->paginate(10);
        return contentResponse($events);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EventHistoryRequest $request)
    {
        $eventHistory = EventHistory::create(array_merge($request->validated(), ['user_id' => auth_user_id()]));
        return messageResponse();
    }

    /**
     * Display the specified resource.
     */
    public function show(EventHistory $history)
    {
        return contentResponse($history);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EventHistoryRequest $request, EventHistory $history)
    {
        $history->update($request->validated());
        return messageResponse();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EventHistory $history)
    {
        $history->forceDelete();
        return messageResponse();
    }
}