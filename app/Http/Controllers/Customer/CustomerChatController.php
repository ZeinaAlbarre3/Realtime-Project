<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Services\Chat\ChatService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerChatController extends Controller
{
    private ChatService $chatService;

    public function __construct(ChatService $chatService){
        $this->chatService = $chatService;
    }

    public function view(Conversation $conversation)
    {
        $user = Auth::user();

        $conversation = $this->chatService->getOrCreateConversationForUser($user);

        return $this->chatService->view($conversation,'customer.chat');
    }
}
