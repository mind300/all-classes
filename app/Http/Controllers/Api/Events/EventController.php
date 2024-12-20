<?php

namespace App\Http\Controllers\Api\Events;

use App\Http\Controllers\Controller;
use App\Http\Requests\Events\EventRequest;
use App\Models\Event;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::with('media')->paginate(10);
        return contentResponse($events);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EventRequest $request)
    {
        $event = Event::create(array_merge($request->validated(), ['user_id' => auth_user_id()]));
        if ($request->hasFile('media')) {
            $event->addMediaFromRequest('media')->toMediaCollection('event');
        }
        return messageResponse();
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        return contentResponse($event->load('media'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EventRequest $request, Event $event)
    {
        $event->update($request->validated());
        if ($request->hasFile('media')) {
            $event->addMediaFromRequest('media')->toMediaCollection('event');
        }
        return messageResponse();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        $event->forceDelete();
        return messageResponse();
    }
}
