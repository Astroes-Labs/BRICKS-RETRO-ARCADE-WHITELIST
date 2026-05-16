<?php
// File: app/Models/Wallet.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    protected $fillable = ['user_id', 'address', 'chain', 'verified'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}