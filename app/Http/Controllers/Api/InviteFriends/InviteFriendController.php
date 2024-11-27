<?php

namespace App\Http\Controllers\Api\InviteFriends;

use App\Http\Controllers\Controller;
use App\Http\Requests\InviteFriends\InviteFriendRequest;
use App\Models\InviteFriend;

class InviteFriendController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $inviteFriends = InviteFriend::with('user')->where('user_id', auth_user_id())->get();
        return contentResponse($inviteFriends);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(InviteFriendRequest $request)
    {
        $inviteFriend = InviteFriend::create(array_merge($request->validated(), ['user_id' => auth_user_id()]));
        return messageResponse();
    }

    /**
     * Display the specified resource.
     */
    public function show(InviteFriend $friend)
    {
        return contentResponse($friend->load('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(InviteFriendRequest $request, InviteFriend $friend)
    {
        $friend->update($request->validated());
        return messageResponse();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InviteFriend $friend)
    {
        $friend->forceDelete();
        return messageResponse();
    }
}
