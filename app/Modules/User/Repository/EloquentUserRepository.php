<?php


namespace App\Modules\User\Repository;


use App\Models\User;
use App\Modules\User\UserEntity;

class EloquentUserRepository implements UserRepositoryInterface
{

    public function getUserAndWallet(int $userId): ?UserEntity
    {
        $user = User::find($userId);

        return UserEntity::newEntityFromModel($user);
    }
}
