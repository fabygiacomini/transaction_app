<?php


namespace App\Modules\Transaction\Validation\Validations;


use App\Modules\User\UserEntity;

interface ValidationInterface
{

    /**
     * Process a validation to verify if a transaction can be made.
     * @param UserEntity $payer
     * @param UserEntity $payee
     * @return boolean
     */
    public function validate(UserEntity $payer, UserEntity $payee, float $transactionValue): bool;

    /**
     * Set next chain's validation.
     * @param ValidationInterface $nextValidation
     * @return mixed
     */
    public function setNext(ValidationInterface $nextValidation): void;
}
