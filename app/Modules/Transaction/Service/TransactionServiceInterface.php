<?php


namespace App\Modules\Transaction\Service;


use App\Modules\Transaction\Repository\TransactionRepositoryInterface;
use App\Modules\Transaction\TransactionEntity;
use App\Modules\Transaction\Validation\ProcessValidations;
use App\Modules\TransactionAuthorizer\Service\TransactionAuthorizerServiceInterface;
use App\Modules\User\Service\UserServiceInterface;
use App\Modules\Wallet\Service\WalletServiceInterface;

interface TransactionServiceInterface
{
    /**
     * TransactionServiceInterface constructor.
     * @param TransactionRepositoryInterface $transactionRepository
     * @param UserServiceInterface $userInterface
     * @param TransactionAuthorizerServiceInterface $authorizerService
     * @param ProcessValidations $processValidations
     * @param WalletServiceInterface $walletService
     */
    public function __construct(
        TransactionRepositoryInterface $transactionRepository,
        UserServiceInterface $userInterface,
        TransactionAuthorizerServiceInterface $authorizerService,
        ProcessValidations $processValidations,
        WalletServiceInterface $walletService
    );

    /**
     * Create a new transaction.
     * @param int $payerId
     * @param int $payeeId
     * @param float $value
     * @return TransactionEntity
     */
    public function create(int $payerId, int $payeeId, float $value): TransactionEntity;
}