<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CopilotController extends Controller
{
    public function getSuggestions(Request $request)
    {
        $apiKey = config('services.openai.api_key');
        $code = $request->input('code');
        $language = $request->input('language');
    
        try {
            $response = Http::withHeaders([
                'Authorization' => "Bearer $apiKey",
                'Content-Type' => 'application/json',
            ])->post('https://api.openai.com/v1/chat/completions', [
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    [
                        'role' => 'user',
                        'content' => "You are copilot. make completion and correction for the code, Point out the errors if present. For this $language code:\n\n$code there is no need to tell me if the code has no errors",
                    ],
                ],
                'max_tokens' => 150,
                'temperature' => 0.5,
                'top_p' => 1,
                'frequency_penalty' => 0,
                'presence_penalty' => 0,
            ]);
            
            $suggestions = $response->json()['choices'][0]['message']['content'] ?? '';
            return response()->json([
                'suggestions' => explode("\n", trim($suggestions)),
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
