export function MessageEffect(messageText, senderTypeFromEvent, currentUserType) {
    const chatBox = document.getElementById('chat-box');
    if (!chatBox) return;

    const isOwnMessage = senderTypeFromEvent === (currentUserType === 'user'
            ? 'App\\Models\\User'
            : 'App\\Models\\SupportStaff'
    );
    const justifyClass = isOwnMessage ? 'justify-end' : 'justify-start';
    const bgClass = isOwnMessage ? 'bg-blue-100 text-blue-800' : 'bg-gray-200 text-gray-800';

    const messageHtml = `
        <div class="flex ${justifyClass}">
            <div class="max-w-xs p-3 my-2 rounded-lg ${bgClass}">
                <p class="text-sm">${messageText}</p>
                <p class="text-xs text-gray-500 mt-1 text-right">
                    ${new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}
                </p>
            </div>
        </div>
    `;

    chatBox.innerHTML += messageHtml;
    chatBox.scrollTop = chatBox.scrollHeight;
}


export function callNotificationCustomEvent($message){
    window.dispatchEvent(new CustomEvent('chat-notify', {
        detail: { message: $message }
    }));
}

