<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MessageRead;
use App\Events\MessageReadEvent;

class MessageReadController extends Controller
{
    public function markAsRead(Request $request)
    {
        $messageId = $request->input('message_id');

        $read = MessageRead::updateOrCreate(
            ['message_id' => $messageId, 'user_id' => auth()->id()],
            ['is_read' => true, 'read_at' => now()]
        );

        broadcast(new MessageReadEvent($read))->toOthers();

        return response()->json(['status' => 'ok']);
    }
}
