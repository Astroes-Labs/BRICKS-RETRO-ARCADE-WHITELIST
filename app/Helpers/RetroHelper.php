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
        return strtoupper(substr(md5(auth()->id() . now()), 0, 8));
    }
}