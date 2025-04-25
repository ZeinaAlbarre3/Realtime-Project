<?php

namespace App\Services\Chat;

use App\Models\Conversation;
use App\Models\SupportStaff;
use App\Models\User;

class ChatService
{

    private const STALE_DAYS = 1;

    public function getOrCreateConversationForUser(User $user): Conversation
    {
        $conversation = $user->conversations()->latest()->first();

        if (!$conversation) {
            $conversation = $user->conversations()->create([
                'support_staff_id' => null,
            ]);
        }

        return $conversation;
    }

    public function assignSupportIfNeeded(Conversation $conversation, SupportStaff $staff): void
    {
        if(is_null($conversation->support_staff_id)) {
            $conversation->update([
                'support_staff_id' => $staff->id
            ]);
        }
    }

    public function view(Conversation $conversation,String $view)
    {
        $this->releaseInactiveConversation($conversation);

        $conversation->load('messages.sender');
        return view($view, [
            'conversation' => $conversation,
            'messages' => $conversation->messages,
        ]);
    }

    private function releaseInactiveConversation(Conversation $conversation): void
    {
        $lastMessage = $conversation->messages()->latest()->first();

        if ($lastMessage && $conversation->support_staff_id && $lastMessage->created_at && $lastMessage->created_at->diffInDays(now()) >= self::STALE_DAYS) {
            $conversation->support_staff_id = null;
            $conversation->save();
        }
    }
}
