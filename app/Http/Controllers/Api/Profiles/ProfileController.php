<?php

namespace App\Http\Controllers\Api\Profiles;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profiles\ProfileRequest;
use App\Models\Profile;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $profiles = Profile::with('user')->get();
        return contentResponse($profiles);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProfileRequest $request)
    {
        $profile = Profile::create($request->validated());
        $profile->user()->associate(auth_user())->save();

        return messageResponse();
    }

    /**
     * Display the specified resource.
     */
    public function show(Profile $profile)
    {
        return contentResponse($profile->load('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProfileRequest $request, Profile $profile)
    {
        $profile->update($request->validated());
        return messageResponse();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Profile $profile)
    {
        $profile->user->forceDelete();
        return messageResponse();
    }
}
