<?php


namespace App\Modules\Transaction\Validation;


use App\Modules\User\UserEntity;

class UserBalanceValidation implements ValidationInterface
{
    /**
     * @var ValidationInterface
     */
    private $nextValidation;

    public function validate(UserEntity $userEntity, float $transactionValue): bool
    {
        if ($userEntity->getBalance() < $transactionValue) {
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