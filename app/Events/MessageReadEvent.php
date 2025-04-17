<?php


namespace App\Events;

use App\Models\MessageRead;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageReadEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $messageRead;

    public function __construct($message)
    {
        $this->messageRead = $message;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('chat.' . $this->messageRead->message->user_id);
    }

    public function broadcastWith()
    {
        return [
            'message_id' => $this->messageRead->message_id,
            'reader_id' => $this->messageRead->user_id,
            'read_at' => $this->messageRead->read_at,
        ];
    }

    public function broadcastAs()
    {
        return 'MessageReadEvent';
    }
}
