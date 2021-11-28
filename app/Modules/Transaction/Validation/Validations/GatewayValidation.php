<?php


namespace App\Modules\Transaction\Validation\Validations;


use App\Modules\TransactionAuthorizer\Service\TransactionAuthorizerServiceInterface;
use App\Modules\User\UserEntity;

class GatewayValidation extends AbstractValidation implements ValidationInterface
{
    /**
     * @var TransactionAuthorizerServiceInterface
     */
    private $authorizerService;

    public function __construct(TransactionAuthorizerServiceInterface $authorizerService)
    {
        $this->authorizerService = $authorizerService;
    }

    /**
     * @inheritDoc
     */
    public function validate(UserEntity $payer, UserEntity $payee, float $transactionValue): bool
    {
        $authorizerResponse = $this->authorizerService->verifyAuthorizator($payer, $transactionValue);

        if ($authorizerResponse != 'Autorizado') {
            return false;
        } else {
            return $this->nextValidation->validate($payer, $payee, $transactionValue);
        }
    }
}
