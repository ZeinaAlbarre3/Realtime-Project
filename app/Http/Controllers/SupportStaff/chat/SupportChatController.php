<?php

namespace App\Http\Controllers\SupportStaff\chat;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\Message;
use App\Services\Chat\ChatService;

class SupportChatController extends Controller
{
    private ChatService $chatService;

    public function __construct(ChatService $chatService){
        $this->chatService = $chatService;
    }

    public function request()
    {
        $allUnassigned = Conversation::with('users')->unassignedWithMessages()->get();

        $myConversations = Conversation::with('users')->assignedTo(auth('support')->id())->get();

        return view('support.chat.requests',[
            'unassigned' => $allUnassigned,
            'mine' => $myConversations,
        ]);
    }

    public function view(Conversation $conversation){
        $this->chatService->assignSupportIfNeeded($conversation,auth('support')->user());
        return $this->chatService->view($conversation,'support.chat.view');
    }
}
