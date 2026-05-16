<?php
// File: app/Models/LeaderboardSnapshot.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LeaderboardSnapshot extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'score',
        'rank',
        'snapshot_date',
    ];

    protected $casts = [
        'score' => 'integer',
        'rank' => 'integer',
        'snapshot_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}