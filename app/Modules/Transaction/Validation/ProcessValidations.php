<?php


namespace App\Modules\Transaction\Validation;

use App\Modules\Transaction\Validation\Validations\EndOfValidation;
use App\Modules\Transaction\Validation\Validations\GatewayValidation;
use App\Modules\Transaction\Validation\Validations\UserBalanceValidation;
use App\Modules\Transaction\Validation\Validations\UserIntegrityValidation;
use App\Modules\Transaction\Validation\Validations\UserTypeValidation;
use App\Modules\TransactionAuthorizer\Service\TransactionAuthorizerServiceInterface;
use App\Modules\User\UserEntity;

class ProcessValidations implements ProcessValidationsInterface
{
    /**
     * @inheritDoc
     */
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
