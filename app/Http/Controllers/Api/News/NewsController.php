<?php

namespace App\Http\Controllers\Api\News;

use App\Events\Notifications;
use App\Events\NotificationSent;
use App\Http\Controllers\Controller;

use App\Http\Requests\News\NewsRequest;
use App\Models\News;
use Illuminate\Support\Facades\Notification;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $news = News::with(['media', 'likes', 'comments.user', 'comments.replies.user'])->paginate(10);
        return contentResponse($news);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(NewsRequest $request)
    {
        $news = News::create(array_merge($request->validated(), ['user_id' => auth_user_id()]));
        if ($request->hasFile('media')) {
            $news->addMediaFromRequest('media')->toMediaCollection('news');
        }
        return messageResponse();
    }

    /**
     * Display the specified resource.
     */
    public function show(News $news)
    {
        return contentResponse($news->load(['media', 'likes', 'comments.user', 'comments.replies.user']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(NewsRequest $request, News $news)
    {
        $news->update($request->validated());
        if ($request->hasFile('media')) {
            $news->addMediaFromRequest('media')->toMediaCollection('news');
        }
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
        $like = $news->likes()->firstWhere('user_id', auth_user_id());

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

    // public function test()
    // {
    //     broadcast(new NotificationSent('message'))->toOthers();
    //     return messageResponse();
    // }
}
