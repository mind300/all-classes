<?php

namespace App\Http\Controllers\Api\Chats;

use App\Events\MessageSent;
use App\Events\NotificationSent;
use App\Http\Controllers\Controller;
use App\Http\Requests\Chats\ChatRequest;
use App\Http\Requests\Chats\MessageRequest;
use App\Models\Chat;
use App\Models\Message;
use App\Models\Notification;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch chats with members and the last message
        $chats = Chat::whereHas('members', function ($query) {
            $query->where('member_id', auth_user_member_id());
        })->with([
            'members' => function ($query) {
                $query->distinct()->select('members.id', 'members.first_name', 'members.last_name', 'members.mobile_number', 'members.user_id');
            },
            'messages' => function ($query) {
                $query->latest()->first();  // Get the latest message for each chat
            }
        ])->get();

        $chats = $chats->map(function ($chat) {
            return [
                'chat_id' => $chat->id,
                'type' => $chat->type,
                'name' => $chat->type === 'group' ? $chat->name : null,
                'last_message' => $chat->messages->isNotEmpty() ? $chat->messages->first()->message : null,
                'members' => $chat->members->filter(function ($member) {
                    return $member->id !== auth_user_member_id();
                })->unique('id')->values(), // Ensure uniqueness and re-index
                'members' => $chat->members->load('media'),
            ];
        });

        return contentResponse($chats);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(ChatRequest $request)
    {
        if ($request->type === 'personal') {
            $existingChat = Chat::where('type', 'personal')->whereHas('members', function ($query) {
                $query->where('member_id', auth_user_member_id());
            })->whereHas('members', function ($query) use ($request) {
                $query->where('member_id', $request->members[0]); // Assuming members array has one recipient
            })->first();

            // If a chat already exists, return it
            if ($existingChat) {
                return contentResponse(['chat_id' => $existingChat->id]);
            }
        }

        // Create a new chat if none exists
        $chat = Chat::create($request->validated());
        $chat->members()->attach(array_merge($request->members, [auth_user_member_id()]));
        return contentResponse(['chat_id' => $chat->id]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MessageRequest $request)
    {
        $message = Message::create(array_merge($request->validated(), ['member_id' => auth_user_member_id()]));
        broadcast(new MessageSent($message))->toOthers();
        broadcast(new NotificationSent($message, $request->validated('user_id')))->toOthers();
        return messageResponse();
    }

    /**
     * Display the specified resource.
     */
    public function show(Chat $chat)
    {
        return contentResponse($chat->load('messages.member'));
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

    public function notification(){
        $notifications = Notification::where('user_id', auth_user_id())->get();
        return contentResponse($notifications);
    }
}
