<?php

namespace App\Http\Controllers\Api\News;

use App\Http\Controllers\Controller;
use App\Http\Requests\News\ReplyRequest;
use App\Models\Reply;
use Illuminate\Http\Request;

class ReplyController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public function store(ReplyRequest $request)
    {
        $reply = Reply::create(array_merge($request->validated(), ['user_id' => auth_user_id()]));
        return messageResponse();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ReplyRequest $request, Reply $reply)
    {
        $reply->update($request->validated());
        return messageResponse();
    }

    /**
     * Display a listing of the resource.
     */
    public function show($comment_id)
    {
        $replies = Reply::with('user')->where('comment_id', $comment_id)->latest()->paginate(10);
        return contentResponse($replies);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reply $reply)
    {
        $reply->forceDelete();
        return messageResponse();
    }
}
