<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use \App\Models\Chat;
use Dotenv\Validator;
class ChatController extends Controller
{
    public function getAllChats(Request $request)
    {
        $chat = Chat::get();
        return response()->json($chat, 201);
    }
    public function createChat(Request $request)
    {
        $request->validate([
            'user1' => 'required|exists:users,id',
            'user2' => 'required|exists:users,id',
        ]);
        $chat = new Chat();
        $chat->user1 = $request->user1;
        $chat->user2 = $request->user2;
        $chat->save();
        return response()->json([
            'chat' => $chat,
            'message' => 'Chat created successfully'
        ], 201);
    }
}
