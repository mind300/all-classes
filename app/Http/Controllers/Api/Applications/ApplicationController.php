<?php

namespace App\Http\Controllers\Api\Applications;

use App\Http\Controllers\Controller;
use App\Http\Requests\Applications\ApplicationRequest;
use App\Models\User;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::with('member.answers')->where('is_active', 1)->paginate(10);
        return contentResponse($user);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ApplicationRequest $request)
    {
        $approve = User::findOrFail($request->validated('user_id'))->update(['is_active' => 1]);
        return messageResponse();
    }
    
    /**
     * Display the specified resource.
     */
    public function show(User $application)
    {
        return contentResponse($application->load('member'));
    }
}
