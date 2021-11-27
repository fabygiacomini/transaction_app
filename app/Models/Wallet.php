<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'balance'
    ];

    /**
     * Define the relationship between Users table
     * and Wallets table (1 -> 1)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
