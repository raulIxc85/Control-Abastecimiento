<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    const ADMIN = 1;
    const STORE = 2;
    const PLANNING = 3;
    const PROGRAMMING = 4;
    const TEST = 5;
    
    protected $keyType = 'string';
    public $incrementing = false;

    public static function booted(){
        static::creating(function ($model){
            $model->id = Str::uuid();
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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

    public function isAdmin()
    {
        return $this->role == static::ADMIN;
    }

    public function isStore()
    {
        return $this->role == static::STORE;
    }

    public function isPlanning()
    {
        return $this->role == static::PLANNING;
    }
    
    public function isProgramming()
    {
        return $this->role == static::PROGRAMMING;
    }

    public function isTest()
    {
        return $this->role == static::TEST;
    }
}
