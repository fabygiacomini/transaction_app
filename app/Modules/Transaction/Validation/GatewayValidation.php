<?php


namespace App\Modules\Transaction\Validation;


use App\Modules\TransactionAuthorizer\Service\TransactionAuthorizerServiceInterface;
use App\Modules\User\UserEntity;

class GatewayValidation implements ValidationInterface
{
    /**
     * @var TransactionAuthorizerServiceInterface
     */
    private $authorizerService;

    /**
     * @var ValidationInterface
     */
    private $nextValidation;

    public function __construct(TransactionAuthorizerServiceInterface $authorizerService)
    {
        $this->authorizerService = $authorizerService;
    }

    public function validate(UserEntity $userEntity, float $transactionValue): bool
    {
        $authorizerResponse = $this->authorizerService->verifyAuthorizator($userEntity, $transactionValue);

        if ($authorizerResponse != 'Autorizado') {
            return false;
        } else {
            return $this->nextValidation->validate($userEntity, $transactionValue);
        }
    }

    public function setNext(ValidationInterface $nextValidation): void
    {
        $this->nextValidation = $nextValidation;
    }
}
