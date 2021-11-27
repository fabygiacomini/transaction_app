<?php


namespace App\Modules\Transaction\Repository;


use App\Modules\Transaction\TransactionEntity;
use App\Modules\User\UserEntity;

interface TransactionRepositoryInterface
{
    /**
     * Insert a new transaction.
     * @param UserEntity $payer
     * @param UserEntity $payee
     * @param float $value
     * @return TransactionEntity
     */
    public function newTransaction(UserEntity $payer, UserEntity $payee, float $value): TransactionEntity;

    /**
     * List all transactions.
     * @return array
     */
    public function getTransactions(): array;
}
