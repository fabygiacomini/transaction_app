<?php


namespace App\Modules\Wallet\Service;


use App\Modules\User\UserEntity;
use App\Modules\Wallet\Repository\WalletRepositoryInterface;

interface WalletServiceInterface
{
    /**
     * WalletServiceInterface constructor.
     * @param WalletRepositoryInterface $walletRepository
     */
    public function __construct(WalletRepositoryInterface $walletRepository);

    /**
     * @param UserEntity $user
     * @param float $value
     */
    public function deposit(UserEntity $user, float $value): void;

    /**
     * @param UserEntity $user
     * @param float $value
     */
    public function withdraw(UserEntity $user, float $value): void;
}
