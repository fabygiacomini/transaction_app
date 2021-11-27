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

    public function getUsers(): array
    {
        // Bring every user with his wallet
        return User::with('wallet')->get()->toArray();
    }

    public function findUser(int $id)
    {
        return User::find($id);
    }

    public function createNewUser(UserEntity $userEntity): UserEntity
    {
        $newUser = new User();

        $newUser = $this->fillUserFields($newUser, $userEntity);

        $newUser->save();

        return UserEntity::newEntityFromModel($newUser);
    }

    public function updateUser(UserEntity $userEntity): ?UserEntity
    {
        $user = User::find($userEntity->getId());

        if (!$user) {
            return null;
        }

        $user = $this->fillUserFields($user, $userEntity);

        $user->save();

        return UserEntity::newEntityFromModel($user);
    }

    function fillUserFields(User $user, UserEntity $userEntity): User
    {

        $user->name = $userEntity->getName();
        $user->email = $userEntity->getEmail();
        $user->password = md5($userEntity->getPassword());
        $user->cpf_cnpj = $userEntity->getCpfCnpj();
        $user->shopkeeper = $userEntity->isShopkeeper();

        return $user;
    }

    public function deleteUser(int $userId): bool
    {
        $user = User::find($userId);

        if (!$user) {
            return false;
        }

        $user->delete();

        return true;
    }
}
