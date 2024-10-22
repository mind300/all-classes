<?php

namespace App\Http\Controllers\Api\Cashires;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cashires\CashierRequest;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class CashierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = (new User)->setConnection('suppliers')->get();
        return contentResponse($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CashierRequest $request)
    {
        $cashier = (new User)->setConnection('suppliers')->create($request->validated());
        return messageResponse();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $cashier = (new User)->setConnection('suppliers')->find($id);
        return contentResponse($cashier);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(CashierRequest $request, string $id)
    {
        $cashier = (new User)->setConnection('suppliers')->find($id)->update($request->validated());
        return messageResponse();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $cashier = (new User)->setConnection('suppliers')->find($id)->forceDelete();
        return messageResponse();
    }
}
