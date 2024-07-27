<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Code_submission extends Model
{
    protected $table = 'code__submissions';
    protected $fillable = ['user_id', 'code'];
    use HasFactory;
    public function user()
    {
        $this->belongsTo(User::class);
    }

}
