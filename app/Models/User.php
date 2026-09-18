<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use App\Models\Task;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasUuids, HasApiTokens,HasFactory, Notifiable;

    protected $fillable = [
        'name', 
        'email', 
        'password', 
        'role'
    ];

    protected $hidden = [
        'password', 
        'remember_token'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function isAdmin():bool
    {
        return $this->role === 'admin';
    }

    public function tasks(){
        return $this->hasMany(Task::class);
    }
}
