<?php


namespace App\Modules\Transaction\Validation\Validations;


use App\Modules\User\UserEntity;

abstract class AbstractValidation implements ValidationInterface
{
    /**
     * @var ValidationInterface
     */
    protected $nextValidation;

    abstract public function validate(UserEntity $payer, UserEntity $payee, float $transactionValue): bool;

    /**
     * @inheritDoc
     */
    public function setNext(ValidationInterface $nextValidation): void
    {
        $this->nextValidation = $nextValidation;
    }
}
