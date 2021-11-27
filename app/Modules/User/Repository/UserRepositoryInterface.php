<?php


namespace App\Modules\User\Repository;


use App\Models\User;
use App\Modules\User\UserEntity;

interface UserRepositoryInterface
{
    /**
     * Find User on database and his wallet
     * @param int $userId
     * @return UserEntity|null
     */
    public function getUserAndWallet(int $userId): ?UserEntity;

    /**
     * List all users
     * @return array
     */
    public function getUsers(): array;


    public function findUser(int $id);

    /**
     * Insert a new user.
     * @param UserEntity $userEntity
     * @return UserEntity
     */
    public function createNewUser(UserEntity $userEntity): UserEntity;


    /**
     * @param UserEntity $userEntity
     * @return UserEntity
     */
    public function updateUser(UserEntity $userEntity): ?UserEntity;

    /**
     * @param User $user
     * @param UserEntity $userEntity
     * @return User
     */
    function fillUserFields(User $user, UserEntity $userEntity): User;

    /**
     * @param int $userId
     * @return bool
     */
    public function deleteUser(int $userId): bool;
}
