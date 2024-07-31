<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function chatsAsUser1()
    {
        return $this->hasMany(Chat::class, 'user1');
    }

    public function chatsAsUser2()
    {
        return $this->hasMany(Chat::class, 'user2');
    }

    public function messages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function code_submission()
    {
        $this->hasMany(Code_submission::class);
    }
    public function chat()
    {
        $this->hasMany(Chat::class);
    }

    public static function importFromCsv($file)
    {
        $data = array_map('str_getcsv', file($file));
        $header = array_shift($data);

        $errors = [];
        $success = 0;

        foreach ($data as $row) {
            $userData = array_combine($header, $row);

            $validator = Validator::make($userData, [
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:8',
            ]);

            if ($validator->fails()) {
                $errors[] = [
                    'row' => $row,
                    'errors' => $validator->errors()->all(),
                ];
                continue;
            }

            User::create([
                'name' => $userData['name'],
                'email' => $userData['email'],
                'password' => Hash::make($userData['password']),
            ]);

            $success++;
        }

        return [
            'message' => 'Import completed',
            'success' => $success,
            'errors' => $errors,
        ];
    }
}
