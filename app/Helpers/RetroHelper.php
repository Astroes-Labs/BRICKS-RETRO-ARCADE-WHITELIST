<?php
// File: app/Helpers/RetroHelper.php
namespace App\Helpers;

class RetroHelper
{
    public static function neonText(string $text): string
    {
        return "<span class='crt-text text-[#B8E1B5FF]'>{$text}</span>";
    }

    public static function generateReferralCode(): string
    {
        return strtoupper(substr(md5(auth()->id() . now()->timestamp . rand(1000, 9999)), 0, 8));
    }

    public static function weightedRandom(array $weights): string
    {
        $total = array_sum($weights);
        $rand = mt_rand(1, $total);

        foreach ($weights as $key => $weight) {
            if ($rand <= $weight) {
                return $key;
            }
            $rand -= $weight;
        }

        return array_key_last($weights);
    }
}