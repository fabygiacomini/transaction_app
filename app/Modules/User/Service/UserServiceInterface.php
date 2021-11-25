<?php


namespace App\Modules\User\Service;


use App\Modules\User\Repository\UserRepositoryInterface;
use App\Modules\User\UserEntity;

interface UserServiceInterface
{
    /**
     * UserServiceInterface constructor.
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository);

    /**
     * @param int $userId
     * @return UserEntity|null
     */
    public function getUserAndWallet(int $userId): ?UserEntity;
}
