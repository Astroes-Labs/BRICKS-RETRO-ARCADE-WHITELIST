<?php
// File: app/Models/Streak.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Streak extends Model
{
    protected $fillable = ['user_id', 'current_streak', 'longest_streak', 'last_checkin_at', 'streak_broken_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}