<?php

namespace App\Http\Controllers\Api\Comments;

use App\Http\Controllers\Controller;
use App\Http\Requests\Comments\CommentRequest;
use App\Models\Comment;

class CommentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(CommentRequest $request)
    {
        // Retrieve the model type and model ID from the request
        $model_type = $request->model_type;
        $model_id = $request->post_id ?? $request->news_id;

        // Set the model class based on the model type
        switch ($model_type) {
            case 'news':
                $model_type = \App\Models\News::class;
                break;
            case 'post':
                $model_type = \App\Models\Post::class;
                break;
        }

        // Create the comment and associate it with the user and model
        $comment = Comment::create($request->safe()->except('model_type') + [
            'user_id' => auth_user_id(),
            'model_id' => $model_id,
            'model_type' => $model_type
        ]);

        // Increment the comment_count on the correct model (either Post or News)
        if ($model_type == \App\Models\News::class) {
            \App\Models\News::where('id', $model_id)->increment('comment_count');
        } elseif ($model_type == \App\Models\Post::class) {
            \App\Models\Post::where('id', $model_id)->increment('comment_count');
        }

        // Return a message response
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
    public function show($model_id, $model_type)
    {
        switch ($model_type) {
            case 'news':
                $model_type = \App\Models\News::class;
                break;
            case 'post':
                $model_type = \App\Models\Post::class;
                break;
        }
        $comments = Comment::with('user')->where([['model_id', $model_id], ['model_type', $model_type]])->paginate(10);
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
