<?php

namespace App\Services\Chat;

use App\Events\NewMessageNotification;
use App\Events\NewMessageNotificationForAllSupport;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\SupportStaff;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;

class ChatService
{

    private const STALE_DAYS = 1;

    public function getOrCreateConversationForUser($user): Conversation
    {
        $conversation = $user->conversations()->latest()->first();

        if (!$conversation) {
            $conversation = $user->conversations()->create([
                'support_staff_id' => null,
            ]);
        }

        return $conversation;
    }

    public function createMessage($request,Conversation $conversation): Message
    {

        $user = $this->checkUserGuard();

        $message = $conversation->messages()->create([
            'text' => $request->text,
            'sender_id' => $user->id,
            'sender_type' => get_class($user),
        ]);

        return $message;
    }

    public function assignSupportIfNeeded(Conversation $conversation, $staff): void
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

    public function CheckIfUserSendTooManyMessages($sender): bool
    {
        $name = $this->getModelName($sender);
        if(Cache::has('user_sent_too_many_messages_'.$name.'_'.$sender->id)) {
            return false;
        }
        Cache::put('user_sent_too_many_messages_'.$name.'_'.$sender->id,true,now()->addSecond(5));
        return true;
    }

    public function getReceiverData(Authenticatable $sender,Conversation $conversation)
    {
        if ($sender instanceof SupportStaff) {
            return [$conversation->user_id, 'user'];
        }

        if ($conversation->support_staff_id) {
            return [$conversation->support_staff_id, 'support'];
        }
        return [null, 'support'];
    }

    public function notifyReceiver(Authenticatable $sender, Conversation $conversation): void
    {
        [$receiverId, $receiverType] = $this->getReceiverData($sender, $conversation);

        if (is_null($receiverId)) {
            SupportStaff::each(function ($staff) use ($sender, $conversation) {
                broadcast(new NewMessageNotificationForAllSupport(
                    'New message from ' . $sender->name,
                    'support',
                    $conversation->id,
                ));
            });
        } else {
            broadcast(new NewMessageNotification(
                'New message from ' . $sender->name,
                $receiverId,
                $receiverType,
                $conversation->id,
            ));
        }
    }

    public function checkUserGuard(): Authenticatable
    {
        return auth('support')->user() ?? auth('web')->user();
    }

    private function getModelName($sender){
        if($sender instanceof SupportStaff) return 'SupportStaff';
        if($sender instanceof User) return 'User';
    }


}
