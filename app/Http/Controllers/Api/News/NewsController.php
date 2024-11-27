<?php

namespace App\Http\Controllers\Api\News;

use App\Http\Controllers\Controller;

use App\Http\Requests\News\CommentRequest;
use App\Http\Requests\News\NewsRequest;
use App\Http\Requests\News\ReplyRequest;

use App\Models\Comment;
use App\Models\News;
use App\Models\Reply;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $news = News::with(['likes', 'comments.user', 'comments.replies.user'])->paginate(10);
        return contentResponse($news);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(NewsRequest $request)
    {
        $news = News::create(array_merge($request->validated(), ['user_id' => auth()->id()]));
        return messageResponse();
    }

    /**
     * Display the specified resource.
     */
    public function show(News $news)
    {
        return contentResponse($news->load(['likes', 'comments.user', 'comments.replies.user']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(NewsRequest $request, News $news)
    {
        $news->update($request->validated());
        return messageResponse();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(News $news)
    {
        $news->forceDelete();
        return messageResponse();
    }

    /**
     * Make like for specific news.
     */
    public function likeOrUnlike(News $news)
    {
        $like = $news->likes()->firstWhere('user_id', auth()->id());

        if ($like) {
            $news->decrement('likes_count');
            $like->forceDelete(); // Dislike if already liked
            return messageResponse('User Unlike');
        } else {
            $news->likes()->create(['user_id' => auth_user_id()]); // Like if not already liked
            $news->increment('likes_count');
        }
        return messageResponse('User Like');
    }
}
