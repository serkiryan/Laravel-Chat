<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
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

    protected $appends = [
        'is_online',
    ];

    protected $attributes = [
        'is_online' => '',
    ];

    public function isOnline() {
        return Cache::has('user-is-online-'.$this->id);
    }

    public function getIsOnlineAttribute(){
        return $this->isOnline();
    }

    // Relations

    public function fromMessages()
    {
        return $this->hasMany(Message::class)->where('from_user_id', $this->id);
    }

    public function toMessages()
    {
        return $this->hasMany(Message::class)->where('to_user_id', $this->id);
    }
}
