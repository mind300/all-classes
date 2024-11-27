<?php

namespace App\Http\Controllers\Api\Cashiers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cashires\CashierRequest;
use App\Models\User;
use App\Models\Cashier;
use Illuminate\Http\Request;

class CashierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $cashiers = Cashier::where('branch_id', $request->has('branch_id') ? $request->branch_id : auth_branch_id())->with('user.profile')->get();
        return contentResponse($cashiers);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CashierRequest $request)
    {
        $user = User::create(array_merge($request->only('email'), ['password' => '12345@Test', 'brand_id' => auth_brand_id()]));
        $user->profile()->create($request->validated());
        $user->syncRoles(['cashier']);
        $user->cashier()->create(['user_id' => $user->id, 'branch_id' => $request->validated('branch_id')]);
        return messageResponse();
    }

    /**
     * Display the specified resource.
     */
    public function show(Cashier $cashier)
    {
        return contentResponse($cashier->load('user.profile'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CashierRequest $request, Cashier $cashier)
    {
        $cashier->user()->update(array_merge($request->only('email')));
        $cashier->user->profile()->update($request->safe()->except(['email', 'branch_id']));
        return messageResponse();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cashier $cashier)
    {
        $cashier->user->forceDelete();
        return messageResponse();
    }
}
