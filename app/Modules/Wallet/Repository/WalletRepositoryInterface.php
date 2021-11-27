<?php


namespace App\Modules\Wallet\Repository;


use App\Modules\User\UserEntity;

interface WalletRepositoryInterface
{
    /**
     * Update user's wallet balance.
     * @param UserEntity $user
     */
    public function updateUserBalance(UserEntity $user): bool;

    /**
     * Create a new wallet for an user.
     * @param UserEntity $userEntity
     */
    public function createWallet(UserEntity $userEntity): void;

    /**
     * Get data of an user's wallet.
     * @param UserEntity $userEntity
     * @return int
     */
    public function getWallet(UserEntity $userEntity): ?int;
}
