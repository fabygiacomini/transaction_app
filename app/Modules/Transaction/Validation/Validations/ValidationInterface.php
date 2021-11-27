<?php


namespace App\Modules\Transaction\Validation\Validations;


use App\Modules\User\UserEntity;

interface ValidationInterface
{

    /**
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
