export function sendNotification(Echo,userType,userId,conversationId,activeConversation,callNotificationCustomEvent){
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
}


