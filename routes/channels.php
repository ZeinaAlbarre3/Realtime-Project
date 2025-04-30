<?php

use App\Models\Conversation;
use App\Models\SupportStaff;
use App\Models\User;
use Illuminate\Support\Facades\Broadcast;


Broadcast::channel('conversation.{conversationId}', function ($user, $conversationId) {
    $conversation = Conversation::findOrFail($conversationId);

    if ($user instanceof User) {
        return $conversation->user_id === $user->id;
    }

    if ($user instanceof SupportStaff) {
        return $conversation->support_staff_id === $user->id;
    }

    return false;
},['guards'=>['support','web']]);


Broadcast::channel('notification.{type}.{id}', function ($user, $type, $id) {
    if ($type === 'user' && $user instanceof User) {
        return $user->id == $id;
    }

    if ($type === 'support' && $user instanceof SupportStaff) {
        return $user->id == $id;
    }
    return false;

}, ['guards' => ['web', 'support']]);

Broadcast::channel('notification.all.support', function ($user, $id) {
    return true;
}, ['guards' => ['web', 'support']]);
