<?php
// File: app/Services/TradeService.php
namespace App\Services;

use App\Models\Trade;
use App\Models\User;
use App\Models\UserPuzzlePiece;
use Illuminate\Support\Facades\DB;

class TradeService
{
    public function transferPiece(User $from, User $to, int $fragmentId, int $xpCost): bool
    {
        return DB::transaction(function () use ($from, $to, $fragmentId, $xpCost) {
            if ($from->total_xp < $xpCost) return false;

            $piece = UserPuzzlePiece::where('user_id', $from->id)
                ->where('puzzle_fragment_id', $fragmentId)
                ->first();

            if (!$piece || $piece->quantity < 1) return false;

            $from->decrement('total_xp', $xpCost);
            $piece->decrement('quantity');

            UserPuzzlePiece::updateOrCreate(
                ['user_id' => $to->id, 'puzzle_fragment_id' => $fragmentId],
                ['quantity' => DB::raw('quantity + 1')]
            );

            Trade::create([
                'from_user_id' => $from->id,
                'to_user_id' => $to->id,
                'puzzle_fragment_id' => $fragmentId,
                'xp_cost' => $xpCost,
            ]);

            return true;
        });
    }
}