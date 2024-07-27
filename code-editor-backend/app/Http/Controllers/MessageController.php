<?php
namespace App\Http\Controllers;
use App\Models\Chat;
use App\Models\Message;
use Illuminate\Http\Request;
class MessageController extends Controller
{
    public function get(Request $request, $chat_id)
    {
        $messages = Message::where('chat_id', $chat_id)->get();
        return response()->json($messages, 200);
    }
    public function createMessage(Request $request, $chat_id)
    {
        $request->validate([
            'sender_id' => 'required|exists:users,id',
            'message' => 'required|string',
        ]);
        $chat = Chat::find($chat_id);
        if (!$chat) {
            return response()->json(['error' => 'Chat not found'], 404);
        }
        $message = new Message();
        $message->chat_id = $chat_id;
        $message->sender_id = $request->sender_id;
        $message->message = $request->message;
        $message->save();
        return response()->json([
            'message' => $message,
        ], 201);
    }
}
