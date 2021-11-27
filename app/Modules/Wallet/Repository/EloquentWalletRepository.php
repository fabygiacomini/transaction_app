<?php


namespace App\Modules\Wallet\Repository;


use App\Models\Wallet;
use App\Modules\User\UserEntity;

class EloquentWalletRepository implements WalletRepositoryInterface
{

    public function updateUserBalance(UserEntity $user): bool
    {
        $wallet = Wallet::where('user_id', $user->getId())->first();

        if (!$wallet) {
            return false;
        }

        $wallet->balance = $user->getBalance();
        $wallet->save();

        return true;
    }

    public function getWallet(UserEntity $userEntity): ?int
    {
        $wallet = Wallet::where('user_id', $userEntity->getId())->get();

        return $wallet->isEmpty() ? null : $wallet->id;
    }

    public function createWallet(UserEntity $userEntity): void
    {
        $wallet = new Wallet();
        $wallet->user_id = $userEntity->getId();
        $wallet->balance = 0;

        $wallet->save();
    }
}
