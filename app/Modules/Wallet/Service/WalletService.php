<?php


namespace App\Modules\Wallet\Service;


use App\Exceptions\TransactionException;
use App\Exceptions\UserException;
use App\Modules\User\UserEntity;
use App\Modules\Wallet\Repository\WalletRepositoryInterface;
use Illuminate\Http\Response;

class WalletService implements WalletServiceInterface
{

    /**
     * @var WalletRepositoryInterface
     */
    private $walletRepository;

    public function __construct(WalletRepositoryInterface $walletRepository)
    {
        $this->walletRepository = $walletRepository;
    }

    /**
     * @inheritDoc
     */
    public function deposit(UserEntity $user, float $value): void
    {
        $newBalance = $user->getBalance() + $value;
        $user->setBalance($newBalance);

        if (!$this->walletRepository->updateUserBalance($user)) {
            throw new TransactionException('Houve um problema para recuperar a carteira do usuário!', Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * @inheritDoc
     */
    public function withdraw(UserEntity $user, float $value): void
    {
        $newBalance = $user->getBalance() - $value;
        $user->setBalance($newBalance);

        if (!$this->walletRepository->updateUserBalance($user)) {
            throw new TransactionException('Houve um problema para recuperar a carteira do usuário!', Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * @inheritDoc
     */
    public function createWallet(UserEntity $userEntity): void
    {
        // if a wallet already exists for this user, we don't create it
        if ($this->getWallet($userEntity)) {
            throw new UserException('Já existe uma carteira para esse usuário!', Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $this->walletRepository->createWallet($userEntity);
    }

    /**
     * @inheritDoc
     */
    public function getWallet(UserEntity $userEntity): ?int
    {
        return $this->walletRepository->getWallet($userEntity);
    }
}
