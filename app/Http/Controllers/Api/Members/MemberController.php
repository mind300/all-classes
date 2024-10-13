<?php

namespace App\Http\Controllers\Api\Members;

use App\Http\Controllers\Controller;
use App\Http\Requests\Members\MemberRequest;

use App\Models\Member;
use App\Models\User;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::with('member')->where('status', 1)->get();
        return contentResponse($user);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MemberRequest $request)
    {
        $member = Member::create($request->validated());
        $member->user()->associate(auth_user())->save();
        $user = User::find(auth_user_id())->update(['name' => "{$member->first_name} {$member->last_name}"]);
        return messageResponse();
    }

    /**
     * Display the specified resource.
     */
    public function show(User $member)
    {
        return contentResponse($member->load('member'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $member)
    {
        return contentResponse($member->load('member'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MemberRequest $request, User $user)
    {
        $user->update($request->validated());
        $user->member->update($request->validated());
        return messageResponse();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $member)
    {
        $member->forceDelete();
        return messageResponse();
    }
}
