<?php


namespace App\Modules\Transaction\Validation;

use App\Modules\TransactionAuthorizer\Service\TransactionAuthorizerServiceInterface;
use App\Modules\User\UserEntity;

class ProcessValidations
{
    public function validateTransaction(
        UserEntity $userPayer,
        UserEntity $userPayee,
        float $transactionValue,
        TransactionAuthorizerServiceInterface $authorizerService
    ): bool
    {
        // Create Chain of Transaction Validations
        $userIntegrity = new UserIntegrityValidation();
        $userTypeValidation = new UserTypeValidation();
        $userBalanceValidation = new UserBalanceValidation();
        $gatewayValidation = new GatewayValidation($authorizerService);
        $endOfValidations = new EndOfValidation();

        $userIntegrity->setNext($userTypeValidation);
        $userTypeValidation->setNext($userBalanceValidation);
        $userBalanceValidation->setNext($gatewayValidation);
        $gatewayValidation->setNext($endOfValidations);

        return $userIntegrity->validate($userPayer, $userPayee, $transactionValue);
    }
}
