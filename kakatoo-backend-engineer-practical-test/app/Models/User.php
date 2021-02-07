<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

   protected $table = 'users';

   protected $casts = [
        'created_at' => 'datetime:Y-m-d H:m:s',
        'updated_at' => 'datetime:Y-m-d H:m:s',
    ];

    protected $fillable = [
        'name', 'email', 'password', 'username', 'profile_id', 'skill_id', 'api_token'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function profile() {
        return $this->belongsTo(Profile::class, 'profile_id', 'id');
    }

    public function skill() {
        return $this->belongsTo(Skill::class, 'skill_id', 'id');
    }
}
