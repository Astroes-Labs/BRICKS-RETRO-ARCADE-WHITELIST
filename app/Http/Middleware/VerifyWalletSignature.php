<?php
// File: app/Http/Middleware/VerifyWalletSignature.php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VerifyWalletSignature
{
    public function handle(Request $request, Closure $next)
    {
        // For production: Verify Ethereum signature
        // Simplified version for shared hosting (can be extended with php-ethereum)
        $wallet = strtolower($request->wallet_address);
        $message = $request->message;
        $signature = $request->signature;

        // Basic validation - In production use proper ECDSA recovery
        if (empty($signature) || strlen($wallet) !== 42) {
            return response()->json(['error' => 'Invalid wallet signature'], 403);
        }

        return $next($request);
    }
}