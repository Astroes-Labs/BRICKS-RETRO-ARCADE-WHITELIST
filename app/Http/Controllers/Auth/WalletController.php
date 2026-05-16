<?php
// File: app/Http/Controllers/Auth/WalletController.php
namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Services\AntiCheatService;

class WalletController extends Controller
{
    protected AntiCheatService $antiCheat;

    public function __construct(AntiCheatService $antiCheat)
    {
        $this->antiCheat = $antiCheat;
    }

    public function connect(Request $request)
    {
        $request->validate([
            'wallet_address' => 'required|string|regex:/^0x[a-fA-F0-9]{40}$/',
            'signature' => 'required|string',
            'message' => 'required|string',
        ]);

        if (!$this->antiCheat->canPerformAction(auth()->user() ?? new User(), 'wallet_connect')) {
            return response()->json(['error' => 'Too many attempts'], 429);
        }

        $user = User::firstOrCreate(
            ['wallet_address' => strtolower($request->wallet_address)],
            [
                'name' => 'Player_' . substr($request->wallet_address, -6),
                'email' => substr($request->wallet_address, 0, 12) . '@temp.arcade',
                'password' => Hash::make(uniqid()),
            ]
        );

        Auth::login($user);

        return response()->json([
            'success' => true,
            'user' => $user->only(['id', 'wallet_address', 'name', 'total_xp', 'referral_code']),
            'redirect' => route('check-in')
        ]);
    }
}