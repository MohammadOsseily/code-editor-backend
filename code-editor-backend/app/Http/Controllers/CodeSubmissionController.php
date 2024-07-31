<?php

namespace App\Http\Controllers;

use App\Models\Code_Submission;
use Illuminate\Http\Request;

class CodeSubmissionController extends Controller
{
    //
    public function readAll()
    {
        $codes = Code_submission::all();
        return response()->json([
            "code" => $codes
        ], 200);
    }

    public function createCode(Request $request)
    {
        Code_submission::create([
            'user_id' => $request->user_id,
            'code' => $request->code,
        ]);

        return response()->json(['message' => 'Code submission successful'], 200);
    }


    public function UserCode($user_id)
    {
        $codes = Code_submission::select('code__submissions.id', 'users.name', 'code__submissions.code')
            ->join('users', 'users.id', '=', 'code__submissions.user_id')
            ->where('code__submissions.user_id', $user_id)
            ->get();

        return response()->json([
            "codes" => $codes
        ]);
    }

    public function DeleteCode($id)
    {
        $code = Code_submission::find($id);
        $code->delete();
        return response()->json([
            "message" => "Code deleted successfully"
        ]);
    }
}
