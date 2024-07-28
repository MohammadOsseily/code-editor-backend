<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }
    public function login(Request $request)
    {
        Log::info('Login request received', ['email' => $request->email]);
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        $credentials = $request->only('email', 'password');
        if (!$token = Auth::attempt($credentials)) {
            Log::warning('Unauthorized login attempt', ['email' => $request->email]);
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 401);
        }
        $user = Auth::user();
        Log::info('User logged in successfully', ['user' => $user->id]);
        // Create a custom token with additional claims
        $token = JWTAuth::claims(['role' => $user->role])->fromUser($user);
        // Decode the token to get its payload
        $decodedToken = JWTAuth::setToken($token)->getPayload()->toArray();
        return response()->json([
            'status' => 'success',
            'user' => $user,
            'authorization' => [
                'token' => $token,
                'type' => 'bearer',
                'decoded_token' => $decodedToken
            ]
        ]);
    }
    public function register(Request $request)
    {
        Log::info('Register request received', ['email' => $request->email]);
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
        ]);
        Log::info('User registered successfully', ['user' => $user->id]);
        // Create a custom token with additional claims
        $token = JWTAuth::claims(['role' => $user->role])->fromUser($user);

        return response()->json([
            'status' => 'success',
            'message' => 'User created successfully',
            'user' => $user,
            'authorization' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);
    }
    public function logout()
    {
        Log::info('Logout request received', ['user' => Auth::user()->id]);
        Auth::logout();
        Log::info('User logged out successfully', ['user' => Auth::user()->id]);
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ]);
    }
    public function refresh()
    {
        Log::info('Token refresh request received', ['user' => Auth::user()->id]);
        $newToken = Auth::refresh();
        $user = Auth::user();

        return response()->json([
            'status' => 'success',
            'user' => $user,
            'authorization' => [
                'token' => $newToken,
                'type' => 'bearer',
            ]
        ]);
    }
}
