<?php

namespace App\Http\Controllers\Api\Rooms;

use App\Http\Controllers\Controller;
use App\Http\Requests\Posts\RoomRequest;
use App\Models\Room;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rooms = Room::get();
        return contentResponse($rooms);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoomRequest $request)
    {
        $room = Room::create($request->validated() + ['user_id' => auth_user_id()]);
        return messageResponse();
    }

    /**
     * Display the specified resource.
     */
    public function show(Room $room)
    {
        return contentResponse($room->load('posts.media','posts.likes','posts.comments.user','posts.comments.replies.user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoomRequest $request, Room $room)
    {
        $room->update($request->validated());
        return messageResponse();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Room $room)
    {
        $room->forceDelete();
        return messageResponse();
    }
}
