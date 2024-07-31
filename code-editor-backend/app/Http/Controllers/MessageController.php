<?php
namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Message;
use App\Events\MessageSent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index(Request $request, $chat_id)
    {
        $messages = Message::with('sender')->where('chat_id', $chat_id)->get();
        return response()->json($messages, 200);
    }

    public function store(Request $request, $chat_id)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        $chat = Chat::find($chat_id);
        if (!$chat) {
            return response()->json(['error' => 'Chat not found'], 404);
        }

        $user = Auth::user();
        if ($chat->user1 != $user->id && $chat->user2 != $user->id) {
            return response()->json(['error' => 'Sender not part of the chat'], 403);
        }

        $message = new Message();
        $message->chat_id = $chat_id;
        $message->sender_id = $user->id;
        $message->message = $request->message;
        $message->save();

        $message->load('sender');

        broadcast(new MessageSent($message))->toOthers();

        return response()->json([
            'message' => $message,
        ], 201);
    }
}
