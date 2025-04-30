<?php
namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class SentNewMessage implements ShouldBroadcast
{
    use SerializesModels;

    public $message;
    public $conversationId;
    public $senderType;

    public function __construct(Message $message, $conversationId)
    {
        $this->message = $message;
        $this->conversationId = $conversationId;
        $this->senderType= $message->sender_type;
    }

    public function broadcastOn(): PrivateChannel
    {
        return new PrivateChannel('conversation.' . $this->conversationId);
    }

    public function broadcastAs(): string
    {
        return 'SentNewMessage';
    }

    public function broadcastWith(): array
    {
        return [
            'message' => $this->message->text,
            'conversationId' => $this->conversationId,
            'senderType' => $this->senderType,
        ];
    }
}
