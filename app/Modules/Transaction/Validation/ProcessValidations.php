<?php


namespace App\Modules\Transaction\Validation;

use App\Modules\TransactionAuthorizer\Service\TransactionAuthorizerServiceInterface;
use App\Modules\User\UserEntity;

class ProcessValidations
{
    public function validateTransaction(
        UserEntity $userEntity,
        float $transactionValue,
        TransactionAuthorizerServiceInterface $authorizerService
    ): bool
    {
        // Create Chain of Transaction Validations
        $userTypeValidation = new UserTypeValidation();
        $userBalanceValidation = new UserBalanceValidation();
        $gatewayValidation = new GatewayValidation($authorizerService);
        $endOfValidations = new EndOfValidation();

        $userTypeValidation->setNext($userBalanceValidation);
        $userBalanceValidation->setNext($gatewayValidation);
        $gatewayValidation->setNext($endOfValidations);

        return $userTypeValidation->validate($userEntity, $transactionValue);
    }
}
