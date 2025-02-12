<?php

namespace App\Http\Controllers\Api\Posts;

use App\Http\Controllers\Controller;
use App\Http\Requests\Posts\PostRequest;
use App\Models\Post;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::with(['media', 'user.member.media', 'likes', 'last_comment.user.member.media'])->latest()->paginate(10);
        return contentResponse($posts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request)
    {
        $post = Post::create($request->validated() + ['user_id' => auth_user_id()]);
        if ($request->hasFile('media')) {
            $post->addMediaFromRequest('media')->toMediaCollection('posts');
        }
        return messageResponse();
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return contentResponse($post);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostRequest $request, Post $post)
    {
        $post->update($request->validated());
        if ($request->hasFile('media')) {
            $post->addMediaFromRequest('media')->toMediaCollection('posts');
        }
        return messageResponse();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->forceDelete();
        return messageResponse();
    }

    /**
     * Make like for specific news.
     */
    public function likeOrUnlike(Post $post)
    {
        $like = $post->likes()->firstWhere('user_id', auth_user_id());

        if ($like) {
            $post->decrement('likes_count');
            $like->forceDelete();
            return messageResponse('User Unlike');
        } else {
            $post->likes()->create(['user_id' => auth_user_id()]); // Like if not already liked
            $post->increment('likes_count');
        }
        return messageResponse('User Like');
    }
}
