@extends('layouts.home')
@section('title', 'Forum Diskusi')

@section('content')

<div class="flex items-center justify-center min-h-screen px-4 bg-gray-100">

    <div class="w-full max-w-sm bg-white shadow-xl rounded-lg overflow-hidden h-[500px] flex flex-col">
        <div class="flex justify-between items-center bg-[#083458] text-white p-3 rounded-t-lg">
            <h2 class="text-base font-semibold">Forum Diskusi</h2>
            <a href="{{ route('user.dashboard') }}" class="text-lg font-bold text-white hover:text-gray-300">&times;</a>
        </div>
        <div id="chat-messages" class="flex-1 p-3 space-y-2 overflow-y-auto text-sm bg-gray-50">
            {{-- Pesan akan dimuat lewat JS --}}
        </div>
        <form id="chat-form" class="flex items-center gap-2 p-3 border-t border-gray-200">
            <input type="text" id="chat-input" class="flex-1 border border-gray-300 rounded-full px-3 py-1.5 text-sm focus:outline-none" placeholder="Ketik pesan..." required>
            <button type="submit" class="bg-[#083458] text-white px-4 py-1.5 text-sm rounded-full hover:bg-[#0a4a78]">Kirim</button>
        </form>
    </div>
</div>

<meta name="csrf-token" content="{{ csrf_token() }}">
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const chatForm = document.getElementById('chat-form');
        const chatInput = document.getElementById('chat-input');
        const chatMessages = document.getElementById('chat-messages');
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const userId = {!! json_encode(auth()->guard('user')->id()) !!};
        function formatName(name) {
            if (!name || typeof name !== 'string') return 'Pengguna';
            return name
                .split(' ')
                .map(word => word.charAt(0).toUpperCase() + word.slice(1).toLowerCase())
                .join(' ');
        }

        async function ambilChat() {
            try {
                const res = await fetch('/forum-chat/load');
                if (!res.ok) throw new Error('Gagal ambil data chat');
                const data = await res.json();

                // Urutkan berdasarkan waktu secara ASCENDING (dari lama ke baru)
                data.sort((a, b) => new Date(a.waktu) - new Date(b.waktu));

                chatMessages.innerHTML = '';

                data.forEach(chat => {
                    const isMe = chat.id_user === userId;
                    const rawName = chat.user?.nama || chat.disdag?.nama || 'Admin Dinas Perdagangan';
                    const senderName = formatName(rawName);
                    const initial = senderName.charAt(0).toUpperCase();
                    const waktu = new Date(chat.waktu);
                    const waktuFormatted = new Intl.DateTimeFormat('id-ID', {
                        hour: '2-digit', minute: '2-digit', timeZone: 'Asia/Makassar'
                    }).format(waktu);

                    const wrapper = document.createElement('div');
                    wrapper.className = `flex items-end ${isMe ? 'justify-end' : 'justify-start'} gap-2`;
                    
                    const bubble = `
                        <div class="max-w-[75%] p-2.5 text-sm leading-snug shadow ${isMe ? 'bg-[#083458] text-white rounded-3xl rounded-br-md' : 'bg-gray-200 text-black rounded-3xl rounded-bl-md'}">
                            <div class="mb-1 text-xs font-semibold">${senderName}</div>
                            <div>${chat.chat.replace(/\n/g, '<br>')}</div>
                            <div class="text-[10px] text-gray-400 text-right mt-1">${waktuFormatted}</div>
                        </div>
                    `;

                    const avatar = `
                        <div class="flex items-center justify-center text-xs font-bold text-white bg-gray-400 rounded-full select-none w-7 h-7">
                            ${initial}
                        </div>
                    `;

                    wrapper.innerHTML = isMe ? `${bubble}${avatar}` : `${avatar}${bubble}`;
                    chatMessages.appendChild(wrapper);
                });

                chatMessages.scrollTop = chatMessages.scrollHeight;
            } catch (err) {
                console.error(err);
            }
        }

        chatForm?.addEventListener('submit', async (e) => {
            e.preventDefault();

            const message = chatInput.value.trim();
            if (!message) return;

            try {
                const response = await fetch('/forum-chat/send', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: JSON.stringify({ chat: message }),
                });

                if (!response.ok) throw new Error('Response not OK');
                const data = await response.json();

                if (data.success) {
                    chatInput.value = '';
                    ambilChat();

                    setTimeout(() => {
                        const waktu = new Date();
                        const waktuFormatted = new Intl.DateTimeFormat('id-ID', {
                            hour: '2-digit',
                            minute: '2-digit',
                            timeZone: 'Asia/Makassar'
                        }).format(waktu);

                        const wrapper = document.createElement('div');
                        wrapper.className = 'flex items-end justify-start gap-2';

                        const autoReply = `
                            <div class="flex items-center justify-center text-xs font-bold text-white bg-gray-400 rounded-full select-none w-7 h-7">
                                A
                            </div>
                            <div class="max-w-[75%] p-2.5 text-sm leading-snug shadow bg-gray-200 text-black rounded-3xl rounded-bl-md">
                                <div class="mb-1 text-xs font-semibold">Admin Dinas Perdagangan</div>
                                <div>Terima kasih atas pesan Anda. Silakan cek forum diskusi secara berkala untuk melihat tanggapan dari tim kami.</div>
                                <div class="text-[10px] text-gray-400 text-right mt-1">${waktuFormatted}</div>
                            </div>
                        `;
                        
                        wrapper.innerHTML = autoReply;
                        chatMessages.appendChild(wrapper);
                        chatMessages.scrollTop = chatMessages.scrollHeight;
                    }, 1500);
                } else {
                    alert('Gagal mengirim pesan');
                }
            } catch (err) {
                console.error('Error:', err);
                alert(err.message);
            }
        });

        ambilChat();
    });
</script>

@endsection