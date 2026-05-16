<?php
// File: app/Models/SeasonalEvent.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SeasonalEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'starts_at',
        'ends_at',
        'multiplier',
        'is_active',
        'metadata',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'is_active' => 'boolean',
        'multiplier' => 'decimal:2',
        'metadata' => 'array',
    ];

    public function isActive(): bool
    {
        $now = now();
        return $this->is_active && 
               $this->starts_at <= $now && 
               $this->ends_at >= $now;
    }
}