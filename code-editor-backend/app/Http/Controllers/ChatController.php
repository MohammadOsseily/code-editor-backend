<?php
namespace App\Http\Controllers;

use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $chats = Chat::with(['user1', 'user2'])
            ->where('user1', $user->id)
            ->orWhere('user2', $user->id)
            ->get();

        return response()->json($chats, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user1' => 'required|exists:users,id',
            'user2' => 'required|exists:users,id',
        ]);

        if ($request->user1 == $request->user2) {
            return response()->json(['error' => 'You cannot create a chat with yourself.'], 400);
        }

        $chat = new Chat();
        $chat->user1 = $request->user1;
        $chat->user2 = $request->user2;
        $chat->save();

        $chat->load(['user1', 'user2']); // Load user names

        return response()->json([
            'chat' => $chat,
            'message' => 'Chat created successfully'
        ], 201);
    }

    public function show($id)
    {
        $chat = Chat::with(['user1', 'user2'])->findOrFail($id);
        return response()->json($chat, 200);
    }
}
