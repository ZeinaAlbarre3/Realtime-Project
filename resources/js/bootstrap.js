/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allow your team to quickly build robust real-time web applications.
 */
import './echo';
import {callNotificationCustomEvent, MessageEffect} from "@/helpers/realTime.js";

const conversationId = document.getElementById('chat-box')?.getAttribute('data-conversation');
const userId = document.body.dataset.userId;
const userType = document.body.dataset.userType;
const activeConversation = document.body.dataset.activeConversation ?? null;



if (conversationId) {
    Echo.private(`conversation.${conversationId}`)
        .listen('.SentNewMessage', (e) => {

            MessageEffect(e.message, e.senderType, userType);
           if (e.senderType === (userType === 'user' ? 'App\\Models\\User' : 'App\\Models\\SupportStaff')) {
                return;
            }
            console.log('New message event received:', e);

});
}

if (userId && userType) {
    Echo.private(`notification.${userType}.${userId}`)
        .listen('.NewMessageNotification', (e) => {
            if (String(e.conversationId) !== String(activeConversation)) {
                console.log('New Notification : ', e.message);
                callNotificationCustomEvent();
            }
        });
}

if (userType === 'support') {
    Echo.channel('notification.all.support')
        .listen('.NewMessageNotificationForAllSupport', (e) => {
            if (String(e.conversationId) !== String(activeConversation)) {
                console.log('Broadcast to all support: ', e.message);
            }
        });
}
