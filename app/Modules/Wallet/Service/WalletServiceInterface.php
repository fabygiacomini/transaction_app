<?php


namespace App\Modules\Wallet\Service;


use App\Exceptions\TransactionException;
use App\Exceptions\UserException;
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
     * Deposit transaction's value on an user's wallet.
     * @param UserEntity $user
     * @param float $value
     * @throws TransactionException
     */
    public function deposit(UserEntity $user, float $value): void;

    /**
     * Withdraw transaction's value on an user's wallet.
     * @param UserEntity $user
     * @param float $value
     * @throws TransactionException
     */
    public function withdraw(UserEntity $user, float $value): void;

    /**
     * Create a new wallet for an user.
     * @param UserEntity $userEntity
     * @throws UserException
     */
    public function createWallet(UserEntity $userEntity): void;

    /**
     * Get data of an user's wallet.
     * @param UserEntity $userEntity
     * @return int
     */
    public function getWallet(UserEntity $userEntity): ?int;
}
