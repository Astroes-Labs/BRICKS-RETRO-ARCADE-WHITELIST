<?php
// File: app/Models/PuzzleFragment.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PuzzleFragment extends Model
{
    use HasFactory;

    protected $fillable = ['puzzle_set_id', 'name', 'number', 'image', 'rarity'];

    public function puzzleSet()
    {
        return $this->belongsTo(PuzzleSet::class);
    }

    public function owners()
    {
        return $this->hasMany(UserPuzzlePiece::class);
    }
}