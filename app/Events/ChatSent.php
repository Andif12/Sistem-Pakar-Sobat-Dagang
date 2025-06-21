<?php

namespace App\Events;

use App\Models\ForumDiskusi;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ChatSent implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $chat;
    public $user;
    public $user_id;
    public $time;

    /**
     * Create a new event instance.
     */
    public function __construct($chat, $user, $user_id, $time)
    {
        $this->chat = $chat;
        $this->user = $user;
        $this->user_id = $user_id;
        $this->time = $time;
    }

    /**
     * Get the channels the event should broadcast on.
     */
    public function broadcastOn()
    {
        return new Channel('forum-chat');
    }

    public function broadcastAs()
    {
        return [
            'id' => $this->chat->id,
            'user' => $this->chat->user->name ?? $this->chat->guest_name,
            'chat' => nl2br(e($this->chat->chat)),
            'time' => $this->chat->created_at->timezone('Asia/Makassar')->format('H:i')
        ];
    }
}
