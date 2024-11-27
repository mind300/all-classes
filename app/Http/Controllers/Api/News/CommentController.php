<?php

namespace App\Http\Controllers\Api\News;

use App\Http\Controllers\Controller;
use App\Http\Requests\News\CommentRequest;
use App\Models\Comment;

class CommentController extends Controller
{
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(CommentRequest $request)
    {
        $comment = Comment::create(array_merge($request->validated(), ['user_id' => auth()->id()]));
        return messageResponse();
    }
    
    /**
     * Update the specified resource in storage.
     */
    public function update(CommentRequest $request, Comment $comment)
    {
        $comment->update($request->validated());
        return messageResponse();
    }

    /**
     * Display a listing of the resource.
     */
    public function show($news_id)
    {
        $comments = Comment::with('user')->where('news_id', $news_id)->latest()->paginate(10);
        return contentResponse($comments);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        $comment->forceDelete();
        return messageResponse();
    }
}
