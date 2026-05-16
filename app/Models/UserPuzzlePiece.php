<?php
// File: app/Models/UserPuzzlePiece.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPuzzlePiece extends Model
{
    protected $fillable = ['user_id', 'puzzle_fragment_id', 'quantity'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function fragment()
    {
        return $this->belongsTo(PuzzleFragment::class, 'puzzle_fragment_id');
    }
}