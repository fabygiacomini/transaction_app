<?php

namespace Database\Seeders;

use App\Models\Wallet;
use Illuminate\Database\Seeder;

class WalletSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Wallet::create([
            'user_id' => 1,
            'balance' => 5000.00
        ]);

        Wallet::create([
            'user_id' => 2,
            'balance' => 1000.00
        ]);
    }
}
