<?php


namespace App\Modules\Transaction\Repository;


use App\Modules\Transaction\TransactionEntity;
use App\Modules\User\UserEntity;

interface TransactionRepositoryInterface
{
    /**
     * @param UserEntity $payer
     * @param UserEntity $payee
     * @param float $value
     * @return TransactionEntity
     */
    public function newTransaction(UserEntity $payer, UserEntity $payee, float $value): TransactionEntity;
}
