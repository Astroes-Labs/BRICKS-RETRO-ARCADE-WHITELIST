<?php
// File: app/Http/Middleware/CheckInThrottle.php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Services\AntiCheatService;

class CheckInThrottle
{
    protected AntiCheatService $antiCheat;

    public function __construct(AntiCheatService $antiCheat)
    {
        $this->antiCheat = $antiCheat;
    }

    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if ($user && !$this->antiCheat->validateCheckIn($user)) {
            return response()->json([
                'error' => 'Check-in cooldown active. Come back in 6 hours.'
            ], 429);
        }

        return $next($request);
    }
}