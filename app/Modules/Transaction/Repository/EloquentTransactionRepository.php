<?php


namespace App\Modules\Transaction\Repository;


use App\Models\Transaction;
use App\Modules\Transaction\TransactionEntity;
use App\Modules\User\UserEntity;

class EloquentTransactionRepository implements TransactionRepositoryInterface
{

    /**
     * @inheritDoc
     */
    public function newTransaction(UserEntity $payer, UserEntity $payee, float $value): TransactionEntity
    {
        $transaction = new Transaction();
        $transaction->payer_id = $payer->getId();
        $transaction->payee_id = $payee->getId();
        $transaction->value = $value;
        $transaction->save();

        return TransactionEntity::newEntityFromModel($transaction);
    }

    /**
     * @inheritDoc
     */
    public function getTransactions(): array
    {
        return Transaction::all()->toArray();
    }
}
