<?php
// File: app/Models/Reward.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reward extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'data',
        'claimed',
        'claimed_at',
    ];

    protected $casts = [
        'data' => 'array',
        'claimed' => 'boolean',
        'claimed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeUnclaimed($query)
    {
        return $query->where('claimed', false);
    }
}