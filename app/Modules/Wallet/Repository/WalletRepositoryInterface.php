<?php


namespace App\Modules\Wallet\Repository;


use App\Modules\User\UserEntity;

interface WalletRepositoryInterface
{
    /**
     * @param UserEntity $user
     */
    public function updateUserBalance(UserEntity $user): bool;

    /**
     * @param UserEntity $userEntity
     */
    public function createWallet(UserEntity $userEntity): void;

    /**
     * @param UserEntity $userEntity
     * @return int
     */
    public function getWallet(UserEntity $userEntity): ?int;
}
