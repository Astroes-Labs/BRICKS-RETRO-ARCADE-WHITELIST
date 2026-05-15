<?php
// File: app/Enums/RewardType.php
namespace App\Enums;

enum RewardType: string
{
    case PUZZLE_FRAGMENT = 'puzzle_fragment';
    case XP = 'xp';
    case STREAK_BOOST = 'streak_boost';
    case WHITELIST_POINT = 'whitelist_point';
    case JACKPOT = 'jackpot';
    case EMPTY = 'empty';
    case MULTIPLIER = 'multiplier';
    case RARE_COLLECTIBLE = 'rare_collectible';
}