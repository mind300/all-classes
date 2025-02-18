<?php

namespace App\Http\Controllers\Api\Admins;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admins\AdminRequest;
use App\Models\User;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admins = User::whereHasRole(['admin'])->paginate(10);
        return contentResponse($admins);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AdminRequest $request)
    {
        $user = User::create(array_merge($request->validated(), ['password' => Str::random(12)]));
        $user->syncRoles(['admin']);
        $user->syncPermissions($request->validated('managments'));
        return messageResponse();
    }

    /**
     * Display the specified resource.
     */
    public function show(User $admin)
    {
        return contentResponse($admin->load('permissions:name'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AdminRequest $request, User $admin)
    {
        $admin->update($request->validated());

        if ($request->has('managments')) {
            $admin->syncPermissions($request->validated('managments'));
        }

        return messageResponse();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $admin)
    {
        $admin->forceDelete();
        return messageResponse();
    }
}