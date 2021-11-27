<?php


namespace App\Modules\Wallet\Repository;


use App\Models\Wallet;
use App\Modules\User\UserEntity;

class EloquentWalletRepository implements WalletRepositoryInterface
{

    public function updateUserBalance(UserEntity $user): bool
    {
        $wallet = Wallet::where('user_id', $user->getId())->get();

        if ($wallet->isEmpty()) {
            return false;
        }

        $wallet->balance = $user->getBalance();
        $wallet->save();

        return true;
    }
}
