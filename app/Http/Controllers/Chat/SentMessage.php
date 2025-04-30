<?php

namespace App\Http\Controllers\Chat;

use App\Events\NewMessageNotification;
use App\Events\NewMessageNotificationForAllSupport;
use App\Events\SentNewMessage;
use App\Http\Controllers\Controller;
use App\Http\Requests\Chat\SentMessageRequest;
use App\Models\Conversation;
use App\Models\SupportStaff;
use App\Services\Chat\ChatService;
use App\Models\User;

class SentMessage extends Controller
{
    private ChatService $chatService;

    public function __construct(ChatService $chatService)
    {
        $this->chatService = $chatService;
    }
    /**
     * @throws \Exception
     */
    public function __invoke(SentMessageRequest $request, Conversation $conversation)
    {
        $sender = $this->chatService->checkUserGuard();

        if (! $this->chatService->CheckIfUserSendTooManyMessages($sender)) {
            return response()->json([
                'message' => 'You are sending messages too fast!',
            ], 429);
        }

        $message = $this->chatService->createMessage($request, $conversation);

        broadcast(new SentNewMessage($message, $conversation->id))->toOthers();

        $this->chatService->notifyReceiver($sender, $conversation);

        return response()->json([
            'message' => 'Message sent successfully!',
            'data' => $message,
        ]);
    }
}
