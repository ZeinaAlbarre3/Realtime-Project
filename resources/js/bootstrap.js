/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allow your team to quickly build robust real-time web applications.
 */

import './echo';
import {callNotificationCustomEvent, MessageEffect} from "@/helpers/realTime.js";
import {sendMessage} from "@/realTime/sendMessage.js";
import {sendNotification} from "@/realTime/notification.js";
import {checkIfUserTyping} from "@/realTime/typing.js";

const conversationId = document.getElementById('chat-box')?.getAttribute('data-conversation');
const input = document.getElementById('message-input');
const userId = document.body.dataset.userId;
const userType = document.body.dataset.userType;
const activeConversation = document.body.dataset.activeConversation ?? null;


sendMessage(Echo,conversationId,userType,MessageEffect);
sendNotification(Echo,userType,userId,conversationId,activeConversation,callNotificationCustomEvent);
checkIfUserTyping(Echo,input,conversationId);


