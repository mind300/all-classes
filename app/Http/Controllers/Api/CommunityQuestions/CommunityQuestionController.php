<?php

namespace App\Http\Controllers\Api\CommunityQuestions;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommunityQuestions\CommunityQuestionRequest;
use App\Models\CommunityQuestion;

class CommunityQuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $communityQuestions = CommunityQuestion::get();
        return contentResponse($communityQuestions);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CommunityQuestionRequest $request)
    {
        $communityQuestions = CommunityQuestion::create($request->validated());
        return messageResponse();
    }

    /**
     * Display the specified resource.
     */
    public function show(CommunityQuestion $question)
    {
        return contentResponse($question);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CommunityQuestionRequest $request, CommunityQuestion $question)
    {
        $question->update($request->validated());
        return messageResponse();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CommunityQuestion $question)
    {
        $question->forceDelete();
        return messageResponse();
    }
}