<?php


namespace App\Modules\Transaction\Service;


use App\Modules\Transaction\Repository\TransactionRepositoryInterface;
use App\Modules\Transaction\TransactionEntity;
use App\Modules\Transaction\Validation\ProcessValidations;
use App\Modules\TransactionAuthorizer\Service\TransactionAuthorizerServiceInterface;
use App\Modules\User\Service\UserServiceInterface;
use Illuminate\Support\Facades\DB;

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
     * @var ProcessValidations
     */
    private $processValidations;

    public function __construct(
        TransactionRepositoryInterface $transactionRepository,
        UserServiceInterface $userInterface,
        TransactionAuthorizerServiceInterface $authorizerService,
        ProcessValidations $processValidations
    )
    {
        $this->transactionRepository = $transactionRepository;
        $this->userService = $userInterface;
        $this->authorizerService = $authorizerService;
        $this->processValidations = $processValidations;
    }

    public function create(int $payerId, int $payeeId, float $value): TransactionEntity
    {
        // Find the payer/payee users and their wallets
        $userPayer = $this->userService->getUserAndWallet($payerId);
        $userPayee = $this->userService->getUserAndWallet($payeeId);

        // Process all the validations required for payer user
        if (!$this->processValidations->validateTransaction($userPayer, $value, $this->authorizerService)) {
            throw new \Exception('A transferência não foi autorizada para este pagador. Cheque as informações e tente novamente.', 401);
        }

        // begin transaction
        try {
            DB::beginTransaction();




            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();

            throw new \Exception('Ocorreu um erro ao realizar a transferência.', 500);
        }
    }
}
