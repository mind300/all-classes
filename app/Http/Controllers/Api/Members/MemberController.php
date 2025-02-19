<?php

namespace App\Http\Controllers\Api\Members;

use App\Http\Controllers\Controller;
use App\Http\Requests\Members\MemberAnswerRequest;
use App\Http\Requests\Members\MemberRequest;

use App\Models\Member;
use App\Models\MemberAnswer;
use App\Models\User;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::with('member.media')->where('is_active', 1)->paginate(10);
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
        if ($request->hasFile('media')) {
            $member->addMediaFromRequest('media')->toMediaCollection('profile');
        }
        if ($request->hasFile('cover')) {
            $member->addMediaFromRequest('cover')->toMediaCollection('cover');
        }
        invite_friend();
        return messageResponse();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function answer(MemberAnswerRequest $request)
    {
        $member = auth_user_member()->answers()->createMany($request->validated('answers'));
        return messageResponse();
    }

    /**
     * Display the specified resource.
     */
    public function show(User $member)
    {
        return contentResponse($member->load('member.media', 'buy_sells', 'jobs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MemberRequest $request, Member $member)
    {
        $member->update($request->validated());
        $member->user->update(array_merge($request->validated(), ['name' => "{$member->first_name} {$member->last_name}"]));
        if ($request->hasFile('media')) {
            $member->addMediaFromRequest('media')->toMediaCollection('profile');
        }
        if ($request->hasFile('cover')) {
            $member->addMediaFromRequest('cover')->toMediaCollection('cover');
        }
        if ($request->filled('media_deleted_id')) {
            $member->media->where('id', $request->media_deleted_id)->first()->delete();
        }
        return messageResponse();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Member $member)
    {
        $member->user->forceDelete();
        return messageResponse();
    }
}
