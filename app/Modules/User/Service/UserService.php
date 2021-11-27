<?php


namespace App\Modules\User\Service;


use App\Exceptions\UserException;
use App\Modules\User\Repository\UserRepositoryInterface;
use App\Modules\User\UserEntity;
use App\Modules\Wallet\Service\WalletServiceInterface;
use Illuminate\Http\Response;

class UserService implements UserServiceInterface
{
    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * @var WalletServiceInterface
     */
    private $walletService;

    public function __construct(
        UserRepositoryInterface $userRepository,
        WalletServiceInterface $walletService
    )
    {
        $this->userRepository = $userRepository;
        $this->walletService = $walletService;
    }

    /**
     * @inheritDoc
     */
    public function getUserAndWallet(int $userId): ?UserEntity
    {
        return $this->userRepository->getUserAndWallet($userId);
    }

    /**
     * @inheritDoc
     */
    public function getUsers(): array
    {
        return $this->userRepository->getUsers();
    }

    /**
     * @inheritDoc
     */
    public function findUser(int $id)
    {
        return $this->userRepository->findUser($id);
    }

    /**
     * @inheritDoc
     */
    public function createNewUser(UserEntity $userEntity): UserEntity
    {
        try {
            // create a new user
            $newUser = $this->userRepository->createNewUser($userEntity);
            // create new user's wallet
            $this->walletService->createWallet($newUser);

        } catch (\Exception $exception) {
            throw $exception;
        }

        return $newUser;
    }

    /**
     * @inheritDoc
     */
    public function updateUser(UserEntity $userEntity): UserEntity
    {
        $user = $this->userRepository->updateUser($userEntity);

        if (!$user) {
            throw new UserException('Usuário a ser atualizado não foi encontrado!', Response::HTTP_NOT_FOUND);
        }

        return $user;
    }

    /**
     * @inheritDoc
     */
    public function deleteUser(int $userId): bool
    {
        if (!$userId) {
            throw new UserException('Dados de usuário inválidos.', Response::HTTP_BAD_REQUEST);
        }

        if (!$this->userRepository->deleteUser($userId)) {
            throw new UserException('Usuário a ser removido não foi encontrado!', Response::HTTP_NOT_FOUND);
        }

        return true;
    }
}
