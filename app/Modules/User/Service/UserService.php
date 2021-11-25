<?php


namespace App\Modules\User\Service;


use App\Modules\User\Repository\UserRepositoryInterface;
use App\Modules\User\UserEntity;

class UserService implements UserServiceInterface
{
    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getUserAndWallet(int $userId): ?UserEntity
    {
        return $this->userRepository->getUserAndWallet($userId);
    }
}
