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

class NewMessageNotificationForAllSupport implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public $message;
    public $receiverType;
    public $conversationId;

    public function __construct(String $message, String $receiverType, Int $conversationId)
    {
        $this->message = $message;
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
        \Log::info('notification1');

        return new Channel('notification.all.support');
    }
    public function broadcastAs(): string
    {
        return 'NewMessageNotificationForAllSupport';
    }

    public function broadcastWith(): array
    {
        return [
            'message' => $this->message,
            'conversationId' => $this->conversationId,];
    }
}
