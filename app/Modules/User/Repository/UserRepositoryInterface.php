<?php


namespace App\Modules\User\Repository;


use App\Modules\User\UserEntity;

interface UserRepositoryInterface
{
    /**
     * Find User on database
     * @param int $userId
     * @return UserEntity|null
     */
    public function getUserAndWallet(int $userId): ?UserEntity;
}
