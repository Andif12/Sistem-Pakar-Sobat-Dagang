@extends('layouts.admin')

@section('title', 'Pengaduan Masyarakat')

@section('content')
<div class="relative w-full h-44">
    <img src="{{ asset('assets/img/background/kepalaDinas_SuperAdmin.jpg') }}" alt="Port Background" class="object-cover w-full h-full">
    <div class="absolute inset-0 flex items-center justify-center">
        <h1 class="text-3xl sm:text-5xl font-bold text-[#FAA31E]">Pengaduan</h1>
    </div>
</div>

<div class="px-4 mx-auto my-6 max-w-7xl">
    <div class="overflow-x-auto bg-white border border-gray-200 shadow-md rounded-xl">
        <div class="overflow-y-auto max-h-[390px]">
            <table class="min-w-full text-sm text-left">
                <thead class="bg-[#083358] text-white text-center font-semibold sticky top-0 z-10">
                    <tr>
                        <th class="px-6 py-3">No</th>
                        <th class="px-6 py-3">Tanggal</th>
                        <th class="px-6 py-3">Nama</th>
                        <th class="px-6 py-3">Pengaduan</th>
                        <th class="px-6 py-3">Aksi</th>
                    </tr>
                </thead>
            <tbody>
                @forelse($pengaduan as $index => $chat)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="px-3 py-2 text-center">{{ $index + 1 }}</td>
                        <td class="px-3 py-2 text-center">{{ \Carbon\Carbon::parse($chat->waktu)->format('d-m-Y H:i') }}</td>
                        <td class="px-3 py-2 text-center">{{ $chat->user->nama ?? '-' }}</td>
                        <td class="px-3 py-2 break-words">{{ $chat->chat }}</td>
                        <td class="px-3 py-2 text-center">
                            @if($chat->id_user !== null)
                                <button
                                    class="px-3 py-1 text-white bg-red-600 rounded hapus-btn hover:bg-red-700"
                                    data-id="{{ $chat->id_pengaduan }}">
                                    Hapus
                                </button>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-4 text-center text-gray-500">Tidak ada pengaduan dari user.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Hapus -->
<div id="modalDelete" class="fixed inset-0 z-50 flex items-center justify-center hidden px-4 ml-24 bg-black bg-opacity-50 rounded-lg sm:justify-center">
    <div class="w-11/12 max-w-md p-6 bg-white shadow-xl rounded-2xl">
        <h2 class="mb-4 text-lg font-semibold">Hapus Pengaduan</h2>
        <p class="mb-6 text-sm text-gray-700">Apakah Anda yakin ingin menghapus pengaduan ini?</p>
        <div class="flex justify-end gap-3">
            <button id="cancelDeleteBtn" class="px-4 py-2 border rounded hover:bg-gray-100">Batal</button>
            <form id="deleteForm" method="POST" action="">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 text-white bg-red-600 rounded hover:bg-red-700">Hapus</button>
            </form>
        </div>
    </div>
</div>

<!-- Tombol Buka Forum -->
<button id="bukaForumBtn" class="fixed bottom-5 right-5 bg-[#083458] p-3 rounded-full shadow-lg hover:scale-110 transition-transform">
    <img src="{{ asset('assets/img/icon/pengaduan.png') }}" alt="Chat" class="w-6 h-6 sm:w-8 sm:h-8">
</button>

<!-- Forum Modal -->
<div id="forumModal" class="fixed inset-0 z-50 flex items-center justify-center hidden ml-24 mr-4 sm:justify-center">
    <div class="bg-white w-full max-w-sm sm:max-w-md h-[500px] rounded-lg shadow-2xl flex flex-col overflow-hidden">
        <div class="bg-[#083458] text-white p-3 flex justify-between items-center">
            <h2 class="text-base font-semibold">Forum Diskusi</h2>
            <button id="tutupForumBtn" class="text-xl font-bold">&times;</button>
        </div>
        <div id="chat-messages" class="flex-1 p-3 space-y-2 overflow-y-auto text-sm bg-gray-50"></div>
        <form id="chat-form" class="flex items-center gap-2 p-3 border-t">
            <input type="text" id="chat-input" class="flex-1 border rounded-full px-3 py-1.5 text-sm focus:outline-none" placeholder="Ketik pesan..." required>
            <button type="submit" class="bg-[#083458] text-white px-4 py-1.5 rounded-full hover:bg-[#0a4a78]">Kirim</button>
        </form>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const modalDelete = document.getElementById('modalDelete');
    const deleteForm = document.getElementById('deleteForm');
    const cancelDeleteBtn = document.getElementById('cancelDeleteBtn');

    // Ketika tombol hapus ditekan
    document.querySelectorAll('button.hapus-btn').forEach(button => {
        button.addEventListener('click', () => {
            const id = button.dataset.id;
            // Set action form delete dengan id pengaduan yang ingin dihapus
            deleteForm.action = `/forum-diskusi/${id}`; // Sesuaikan route hapus sesuai route di web.php
            modalDelete.classList.remove('hidden');
        });
    });

    // Tombol batal tutup modal
    cancelDeleteBtn.addEventListener('click', () => {
        modalDelete.classList.add('hidden');
        deleteForm.action = '';
    });

    // Tutup modal jika klik di luar box modal
    modalDelete.addEventListener('click', (e) => {
        if (e.target === modalDelete) {
            modalDelete.classList.add('hidden');
            deleteForm.action = '';
        }
    });

    const bukaBtn = document.getElementById('bukaForumBtn');
    const tutupBtn = document.getElementById('tutupForumBtn');
    const modal = document.getElementById('forumModal');
    const chatForm = document.getElementById('chat-form');
    const chatInput = document.getElementById('chat-input');
    const chatMessages = document.getElementById('chat-messages');
    const adminId = {!! json_encode(auth()->guard('disdag')->id()) !!};

    function showModal() {
        modal.classList.remove('hidden');
        loadMessages();
    }

    function hideModal() {
        modal.classList.add('hidden');
    }

    bukaBtn.addEventListener('click', showModal);
    tutupBtn.addEventListener('click', hideModal);

    function formatName(name) {
        if (!name || typeof name !== 'string') return 'Pengguna';
        return name
            .split(' ')
            .map(word => word.charAt(0).toUpperCase() + word.slice(1).toLowerCase())
            .join(' ');
    }
    async function loadMessages() {
        try {
            const res = await fetch('/forum/load');
            const data = await res.json();
            chatMessages.innerHTML = '';
            data.forEach(chat => {
                const isFromAdmin = chat.id_disdag !== null;
                const isMe = chat.id_disdag === adminId;

                let senderName;
                if (chat.id_disdag !== null) {
                    senderName = 'Admin Dinas Perdagangan';
                } else if (chat.user && chat.user.nama) {
                    senderName = formatName(chat.user.nama);
                } else {
                    senderName = 'Pengguna';            
                }
                const waktu = new Date(chat.waktu);
                const waktuFormatted = new Intl.DateTimeFormat('id-ID', {
                    hour: '2-digit',
                    minute: '2-digit',
                    timeZone: 'Asia/Makassar'
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
                        ${senderName.charAt(0).toUpperCase()}
                    </div>
                `;

                wrapper.innerHTML = isMe ? `${bubble}${avatar}` : `${avatar}${bubble}`;
                chatMessages.appendChild(wrapper);
            });
            chatMessages.scrollTop = chatMessages.scrollHeight;
        } catch (error) {
            console.error('Gagal memuat chat:', error);
        }
    }

    chatForm.addEventListener('submit', async (e) => {
        e.preventDefault();

        const message = chatInput.value.trim();
        if (!message) return;

        try {
            const response = await fetch('/kirim-pesan', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                body: JSON.stringify({ message }),
            });

            if (!response.ok) {
                const contentType = response.headers.get('content-type');
                if (!contentType || !contentType.includes('application/json')) {
                    alert('Sesi Anda mungkin telah berakhir. Silakan login kembali.');
                    window.location.href = '/login';
                    return;
                }
                const errorData = await response.json();
                console.error('Error saat kirim pesan:', errorData);
                alert('Gagal mengirim pesan.');
                return;
            }

            chatInput.value = '';
            loadMessages();
        } catch (error) {
            console.error('Terjadi kesalahan:', error);
            alert('Terjadi kesalahan saat mengirim pesan.');
        }
    });
});
</script>
@endsection
