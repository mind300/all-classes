<?php

namespace App\Http\Controllers\Api\Branches;

use App\Http\Controllers\Controller;
use App\Http\Requests\Branches\BranchRequest;
use App\Models\Branch;
use App\Models\User;
use Laratrust\Models\Role;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $branches = Branch::with('manager.profile')->paginate(10);
        return contentResponse($branches);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BranchRequest $request)
    {
        $user = User::create(array_merge($request->only('email'), ['password' => '12345@Test', 'brand_id' => auth_user()->brand_id]));
        $user->syncRoles(['manager']);
        $user->profile()->create($request->validated());
        $branch = Branch::create(array_merge($request->validated(), ['manager_id' => $user->id, 'owner_id' => auth_user_id()]));
        return messageResponse();
    }

    /**
     * Display the specified resource.
     */
    public function show(Branch $branch)
    {
        return contentResponse($branch->load('manager'));
    }
    
    /**
     * Edit the specified resource.
     */
    public function edit(Branch $branch)
    {
        return contentResponse($branch->load('manager.profile'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BranchRequest $request, Branch $branch)
    {
        $branch->update($request->validated());
        $branch->manager()->update($request->safe()->only('email'));
        $branch->manager->profile()->update($request->safe()->only(['name', 'mobile_number', 'job_id']));
        return messageResponse();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Branch $branch)
    {
        $branch->manager->forceDelete();
        return messageResponse();
    }
}