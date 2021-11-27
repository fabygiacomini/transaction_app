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

    /**
     * Find one user by id.
     * @param int $id
     * @return mixed
     */
    public function findUser(int $id);

    /**
     * Insert a new user.
     * @param UserEntity $userEntity
     * @return UserEntity
     */
    public function createNewUser(UserEntity $userEntity): UserEntity;

    /**
     * Update an user fields.
     * @param UserEntity $userEntity
     * @return UserEntity
     */
    public function updateUser(UserEntity $userEntity): ?UserEntity;

    /**
     * Fill the fiels of user model with entity attributes.
     * @param User $user
     * @param UserEntity $userEntity
     * @return User
     */
    function fillUserFields(User $user, UserEntity $userEntity): User;

    /**
     * Remove an user form database.
     * @param int $userId
     * @return bool
     */
    public function deleteUser(int $userId): bool;
}
