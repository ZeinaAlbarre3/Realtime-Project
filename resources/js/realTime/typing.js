let typingTimeout = null;

export function checkIfUserTyping(Echo,input,conversationId) {
    if (input && conversationId) {
        input.addEventListener('input', () => {
            Echo.private(`conversation.${conversationId}`)
                .whisper('typing', {});

            clearTimeout(typingTimeout);
            typingTimeout = setTimeout(() => {
                Echo.private(`conversation.${conversationId}`)
                    .whisper('stoppedTyping', {});
            }, 2000);
        });

        if (conversationId) {
            Echo.private(`conversation.${conversationId}`)
                .listenForWhisper('typing', (e) => {
                    console.log('typing..', e.userId);
                });

            Echo.private(`conversation.${conversationId}`)
                .listenForWhisper('stoppedTyping', (e) => {
                    console.log('stoppedTyping', e.userId);

                });
        }

    }
}

