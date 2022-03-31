<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use function PHPUnit\Framework\returnArgument;

class Message extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'from_user_id',
        'to_user_id',
        'message',
    ];

    // Relations

    public function from_user()
    {
        return $this->belongsTo(User::class)->where('id', $this->from_user_id);
    }

    public function to_user()
    {
        return $this->belongsTo(User::class)->where('id', $this->to_user_id);
    }
}
