window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: '332ab41407b67d0d3e9a',
    cluster: 'us2',
    forceTLS: true
});

window.Echo.channel('forum-diskusi')
    .listen('ChatSent', (e) => {
        const el = document.createElement('li');    
        el.className = "text-sm";
        el.innerHTML = `<span class="font-bold">${e.user}</span> 
                        <span class="text-gray-500 text-xs">[${e.time}]</span>: 
                        ${e.chat}`;
        document.getElementById('chat-list').appendChild(el);
    });

document.getElementById('chat-form').addEventListener('submit', function (e) {
    e.preventDefault();

    const chatInput = document.getElementById('chat-input');
    const chat = chatInput.value;

    fetch("/chat", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value
        },
        body: JSON.stringify({ chat: chat })
    });

    chatInput.value = '';
});
