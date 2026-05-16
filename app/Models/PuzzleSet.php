<?php
// File: app/Models/PuzzleSet.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PuzzleSet extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'description', 'image', 'rarity', 'whitelist_reward', 'mint_bonus', 'is_active'];

    public function fragments()
    {
        return $this->hasMany(PuzzleFragment::class);
    }

    public function isCompleteForUser(User $user): bool
    {
        $collected = $user->puzzlePieces()
            ->whereIn('puzzle_fragment_id', $this->fragments->pluck('id'))
            ->count();

        return $collected >= 7; // All unique fragments
    }
}