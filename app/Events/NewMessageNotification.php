<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Laravel\Reverb\Loggers\Log;

class NewMessageNotification implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public $message;
    public $receiverId;
    public $receiverType;
    public $conversationId;

    public function __construct(String $message,?int $receiverId, String $receiverType, Int $conversationId)
    {
        $this->message = $message;
        $this->receiverId = $receiverId;
        $this->receiverType = $receiverType;
        $this->conversationId = $conversationId;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): Channel
    {
        \Log::info('notification');

        return new PrivateChannel("notification.{$this->receiverType}.{$this->receiverId}");

    }
    public function broadcastAs(): string
    {
        return 'NewMessageNotification';
    }

    public function broadcastWith(): array
    {
        return [
            'message' => $this->message,
            'conversationId' => $this->conversationId,];
    }
}
