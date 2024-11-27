<?php

namespace App\Http\Controllers\Api\Chats;

use App\Events\MessageSent;
use App\Http\Controllers\Controller;
use App\Http\Requests\Chats\ChatRequest;
use App\Http\Requests\Chats\MessageRequest;
use App\Models\Chat;
use App\Models\Message;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch chats with members and last message
        $chats = Chat::whereHas('members', function ($query) {
            $query->where('user_id', auth_user_id());
        })->with([
            'members' => function ($query) {
                $query->where('users.id', '!=', auth_user_id())->select('users.id', 'users.name');
            },
            'messages' => function ($query) {
                $query->latest()->first(); // Get the last message for each chat
            }
        ])->get();

        // Transform the data for the response
        $chats = $chats->map(function ($chat) {
            return [
                'id' => $chat->id,
                'type' => $chat->type,
                'name' => $chat->type === 'group' ? $chat->name : null,
                'last_message' => $chat->messages->isNotEmpty() ? $chat->messages->first()->message : null,
                'members' => $chat->members->map(function ($member) {
                    return ['id' => $member->id, 'name' => $member->name,];
                }),
            ];
        });

        return contentResponse($chats);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(ChatRequest $request)
    {
        $chat = Chat::create($request->validated());
        $chat->members()->attach($request->members); // Array of user IDs
        return messageResponse();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MessageRequest $request)
    {
        $message = Message::create(array_merge($request->validated(), ['user_id' => auth_user_id()]));
        broadcast(new MessageSent($message))->toOthers();
        return messageResponse();
    }

    /**
     * Display the specified resource.
     */
    public function show(Chat $chat)
    {
        return contentResponse($chat->load('messages.user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
