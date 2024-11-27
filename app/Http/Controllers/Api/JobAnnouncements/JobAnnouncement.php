<?php

namespace App\Http\Controllers\Api\Jobs;

use App\Http\Controllers\Controller;
use App\Http\Requests\Jobs\JobRequest;
use App\Models\JobAnnouncement;
use App\Models\PointSystem;
use Illuminate\Http\Request;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jobAnnouncements = JobAnnouncement::with('user')->paginate(10);
        return contentResponse($jobAnnouncements);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(JobRequest $request)
    {
        $job = JobAnnouncement::create(array_merge($request->validated(), ['user_id' => auth()->id()]));
        point_system('jobs');
        return messageResponse();
    }

    /**
     * Display the specified resource.
     */
    public function show(JobAnnouncement $job)
    {
        return contentResponse($job->load('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(JobRequest $request, JobAnnouncement $job)
    {
        $job->update($request->validated());
        return messageResponse();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JobAnnouncement $job)
    {
        $job->forceDelete();
        return messageResponse();
    }
}
