<?php


namespace App\Modules\User\Service;


use App\Exceptions\UserException;
use App\Modules\User\Repository\UserRepositoryInterface;
use App\Modules\User\UserEntity;
use App\Modules\Wallet\Service\WalletServiceInterface;

interface UserServiceInterface
{
    /**
     * UserServiceInterface constructor.
     * @param UserRepositoryInterface $userRepository
     * @param WalletServiceInterface $walletService
     */
    public function __construct(
        UserRepositoryInterface $userRepository,
        WalletServiceInterface $walletService
    );

    /**
     * @param int $userId
     * @return UserEntity|null
     */
    public function getUserAndWallet(int $userId): ?UserEntity;


    /**
     * List all users
     * @return array
     */
    public function getUsers(): array;

    /**
     * Find one user on database.
     * @param int $id
     * @return mixed
     */
    public function findUser(int $id);

    /**
     * Insert a new user.
     * @param UserEntity $userEntity
     * @return UserEntity
     * @throws \Exception
     */
    public function createNewUser(UserEntity $userEntity): UserEntity;

    /**
     * Update user fields.
     * @param UserEntity $userEntity
     * @return UserEntity
     * @throws UserException
     */
    public function updateUser(UserEntity $userEntity): UserEntity;


    /**
     * Remove an user from database.
     * @param int $userId
     * @return bool
     * @throws UserException
     */
    public function deleteUser(int $userId): bool;
}
