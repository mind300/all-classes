<?php

namespace App\Http\Controllers\Api\BuySell;

use App\Http\Controllers\Controller;
use App\Http\Requests\BuySell\BuySellRequest;
use App\Models\BuySell;
use Illuminate\Http\Request;

class BuySellController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $buysell = BuySell::when($request->user_id, function ($query) use ($request) {
            return $query->where('user_id', $request->user_id);
        })
            ->with(['media', 'user.member.media'])
            ->paginate(10);
        return contentResponse($buysell);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BuySellRequest $request)
    {
        $buysell = BuySell::create(array_merge($request->validated(), ['user_id' => auth_user_id()]));
        if ($request->hasFile('media')) {
            $buysell->addMediaFromRequest('media')->toMediaCollection('buy_sell');
        }
        point_system('buy_sell');
        return contentResponse($buysell);
    }

    /**
     * Display the specified resource.
     */
    public function show(BuySell $buysell)
    {
        return contentResponse($buysell->load('media'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BuySellRequest $request, BuySell $buysell)
    {
        $buysell->update($request->validated());
        if ($request->hasFile('media')) {
            $buysell->addMediaFromRequest('media')->toMediaCollection('buy_sell');
        }
        return messageResponse();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BuySell $buysell)
    {
        $buysell->forceDelete();
        return messageResponse();
    }
}
