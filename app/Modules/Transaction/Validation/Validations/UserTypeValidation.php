<?php


namespace App\Modules\Transaction\Validation\Validations;


use App\Modules\User\UserEntity;

class UserTypeValidation implements ValidationInterface
{
    /**
     * @var ValidationInterface;
     */
    private $nextValidation;

    /**
     * @inheritDoc
     */
    public function validate(UserEntity $payer, UserEntity $payee, float $transactionValue): bool
    {
        if ($payer->isShopkeeper()) {
            return false;
        } else {
            return $this->nextValidation->validate($payer, $payee, $transactionValue);
        }
    }

    /**
     * @inheritDoc
     */
    public function setNext(ValidationInterface $nextValidation): void
    {
        $this->nextValidation = $nextValidation;
    }
}
