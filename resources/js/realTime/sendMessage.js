export function sendMessage(Echo,conversationId,userType,MessageEffect){
    if(conversationId) {
        Echo.private(`conversation.${conversationId}`)
            .listen('.SentNewMessage', (e) => {

                MessageEffect(e.message, e.senderType, userType);
                if (e.senderType === (userType === 'user' ? 'App\\Models\\User' : 'App\\Models\\SupportStaff')) {
                    return;
                }
                console.log('New message event received:', e);

            });
    }
}
