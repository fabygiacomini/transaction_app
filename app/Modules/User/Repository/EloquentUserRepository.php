<?php


namespace App\Modules\User\Repository;


use App\Models\User;
use App\Modules\User\UserEntity;

class EloquentUserRepository implements UserRepositoryInterface
{

    /**
     * @inheritDoc
     */
    public function getUserAndWallet(int $userId): ?UserEntity
    {
        $user = User::find($userId);

        return UserEntity::newEntityFromModel($user);
    }

    /**
     * @inheritDoc
     */
    public function getUsers(): array
    {
        // Bring every user with his wallet
        return User::with('wallet')->get()->toArray();
    }

    /**
     * @inheritDoc
     */
    public function findUser(int $id)
    {
        return User::find($id);
    }

    /**
     * @inheritDoc
     */
    public function createNewUser(UserEntity $userEntity): UserEntity
    {
        $newUser = new User();

        $newUser = $this->fillUserFields($newUser, $userEntity);

        $newUser->save();

        return UserEntity::newEntityFromModel($newUser);
    }

    /**
     * @inheritDoc
     */
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

    /**
     * @inheritDoc
     */
    function fillUserFields(User $user, UserEntity $userEntity): User
    {

        $user->name = $userEntity->getName();
        $user->email = $userEntity->getEmail();
        $user->password = md5($userEntity->getPassword());
        $user->cpf_cnpj = $userEntity->getCpfCnpj();
        $user->shopkeeper = $userEntity->isShopkeeper();

        return $user;
    }

    /**
     * @inheritDoc
     */
    public function deleteUser(int $userId): bool
    {
        $user = User::find($userId);

        if (!$user) {
            return false;
        }

        $wallet = $user->wallet;
        // if a wallet exists for this user, remove the wallet so
        // we can remove the user (foreign key in use)
        if ($wallet) {
            $wallet->delete();
        }

        $user->delete();

        return true;
    }
}
