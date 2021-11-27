<?php


namespace App\Modules\Wallet\Repository;


use App\Modules\User\UserEntity;

interface WalletRepositoryInterface
{
    /**
     * @param UserEntity $user
     */
    public function updateUserBalance(UserEntity $user): bool;
}
