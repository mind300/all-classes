<?php

namespace App\Http\Controllers\Api\PointHistories;

use App\Http\Controllers\Controller;
use App\Http\Requests\PointHistories\PointHistoryRequest;
use App\Models\PointHistory;

class PointHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pointHistories = PointHistory::with('point_system')->where('user_id', auth_user_id())->paginate(10);
        return contentResponse($pointHistories);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PointHistoryRequest $request, PointHistory $history)
    {
        $history->update($request->validated());
        return messageResponse();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PointHistory $history)
    {
        $history->forceDelete();
        return messageResponse();
    }
}
