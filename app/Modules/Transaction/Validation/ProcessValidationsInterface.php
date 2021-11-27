<?php


namespace App\Modules\Transaction\Validation;

use App\Modules\TransactionAuthorizer\Service\TransactionAuthorizerServiceInterface;
use App\Modules\User\UserEntity;

/**
 * Define the validations that will compose the Chain
 *
 * Interface ProcessValidationsInterface
 * @package App\Modules\Transaction\Validation
 */
interface ProcessValidationsInterface
{

    /**
     * Create and call the chain of validations.
     * @param UserEntity $userPayer
     * @param UserEntity $userPayee
     * @param float $transactionValue
     * @param TransactionAuthorizerServiceInterface $authorizerService
     * @return bool
     */
    public function validateTransaction(
        UserEntity $userPayer,
        UserEntity $userPayee,
        float $transactionValue,
        TransactionAuthorizerServiceInterface $authorizerService
    ): bool;
}
