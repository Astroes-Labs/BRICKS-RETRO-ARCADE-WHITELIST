<?php
// File: app/Models/User.php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable, HasRoles;

    protected $fillable = [
        'name', 'email', 'password', 'wallet_address', 'referral_code',
        'total_xp', 'whitelist_points', 'mint_allocation', 'last_checkin_at'
    ];

    protected $hidden = ['password', 'remember_token'];
    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_checkin_at' => 'datetime',
        'is_banned' => 'boolean',
        'metadata' => 'array',
    ];

    // Relationships
    public function wallet()
    {
        return $this->hasOne(Wallet::class);
    }

    public function referrals()
    {
        return $this->hasMany(Referral::class, 'referrer_id');
    }

    public function puzzlePieces()
    {
        return $this->hasMany(UserPuzzlePiece::class);
    }

    public function checkIns()
    {
        return $this->hasMany(CheckIn::class);
    }

    public function streak()
    {
        return $this->hasOne(Streak::class);
    }

    public function xpLogs()
    {
        return $this->hasMany(XpLog::class);
    }

    public function rewards()
    {
        return $this->hasMany(Reward::class);
    }

    public function tradesSent()
    {
        return $this->hasMany(Trade::class, 'from_user_id');
    }

    public function tradesReceived()
    {
        return $this->hasMany(Trade::class, 'to_user_id');
    }

    public function leaderboardSnapshots()
    {
        return $this->hasMany(LeaderboardSnapshot::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_banned', false);
    }

    public function scopeWithStreak($query)
    {
        return $query->with('streak');
    }

    // Helper Methods
    public function getReferralMultiplierAttribute(): float
    {
        $count = $this->referrals()->count();
        if ($count >= 500) return 2.2;
        if ($count >= 100) return 2.1;
        if ($count >= 50) return 2.0;
        if ($count >= 25) return 1.85;
        if ($count >= 10) return 1.6;
        if ($count >= 5) return 1.45;
        if ($count >= 1) return 1.2;
        return 1.0;
    }

    public function canCheckIn(): bool
    {
        if (!$this->last_checkin_at) return true;
        return $this->last_checkin_at->diffInHours(now()) >= 6;
    }
}