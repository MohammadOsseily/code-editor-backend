<?php
namespace App\Http\Controllers;

use App\Models\Chat;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index()
    {
        $chats = Chat::all();
        return response()->json($chats);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user1' => 'required|exists:users,id',
            'user2' => 'required|exists:users,id|different:user1',
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
