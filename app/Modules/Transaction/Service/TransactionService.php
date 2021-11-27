<?php


namespace App\Modules\Transaction\Service;


use App\Exceptions\TransactionException;
use App\Modules\Transaction\Repository\TransactionRepositoryInterface;
use App\Modules\Transaction\TransactionEntity;
use App\Modules\Transaction\Validation\ProcessValidationsInterface;
use App\Modules\TransactionAuthorizer\Service\TransactionAuthorizerServiceInterface;
use App\Modules\User\Service\UserServiceInterface;
use App\Modules\Wallet\Service\WalletServiceInterface;
use App\Send\SendNotification;
use Illuminate\Http\Response;

class TransactionService implements TransactionServiceInterface
{

    /**
     * @var TransactionRepositoryInterface
     */
    private $transactionRepository;

    /**
     * @var UserServiceInterface
     */
    private $userService;

    /**
     * @var TransactionAuthorizerServiceInterface
     */
    private $authorizerService;

    /**
     * @var ProcessValidationsInterface
     */
    private $processValidations;

    /**
     * @var WalletServiceInterface
     */
    private $walletService;

    public function __construct(
        TransactionRepositoryInterface $transactionRepository,
        UserServiceInterface $userInterface,
        TransactionAuthorizerServiceInterface $authorizerService,
        ProcessValidationsInterface $processValidations,
        WalletServiceInterface $walletService
    )
    {
        $this->transactionRepository = $transactionRepository;
        $this->userService = $userInterface;
        $this->authorizerService = $authorizerService;
        $this->processValidations = $processValidations;
        $this->walletService = $walletService;
    }

    /**
     * @inheritDoc
     */
    public function getTransactions(): array
    {
        return $this->transactionRepository->getTransactions();
    }

    /**
     * @inheritDoc
     */
    public function create(int $payerId, int $payeeId, float $value): TransactionEntity
    {
        // Find the payer/payee users and their wallets
        $userPayer = $this->userService->getUserAndWallet($payerId);
        $userPayee = $this->userService->getUserAndWallet($payeeId);

        // Process all the validations required for payer user
        $transactionPermitted = $this->processValidations->validateTransaction($userPayer, $userPayee, $value, $this->authorizerService);
        if (!$transactionPermitted) {
            throw new TransactionException('A transferência não foi autorizada para este pagador. Cheque as informações e tente novamente.', Response::HTTP_UNAUTHORIZED);
        }

        try {

            $this->walletService->withdraw($userPayer, $value);
            $this->walletService->deposit($userPayee, $value);

            return $this->transactionRepository->newTransaction($userPayer, $userPayee, $value);

        } catch (TransactionException $transactionException) {
            throw $transactionException;
        } catch (\Exception $exception) {

            throw new TransactionException('Ocorreu um erro ao realizar a transferência.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @inheritDoc
     */
    public function notifyTransactionPayee(TransactionEntity $transactionEntity): bool
    {
        $payee = $this->userService->getUserAndWallet($transactionEntity->getPayeeId());

        if (!$payee) {
            throw new \Exception('Usuário não encontrado!', Response::HTTP_NOT_FOUND);
        }

        try {
            return SendNotification::notificate($payee);

        } catch (\Exception $exception) {
            throw $exception;
        }
    }
}
