<?php


namespace App\Modules\Transaction\Validation;


use App\Modules\User\UserEntity;

interface ValidationInterface
{

    /**
     * @param UserEntity $userEntity
     * @return boolean
     */
    public function validate(UserEntity $userEntity, float $transactionValue): bool;

    /**
     * Set next chain's validation.
     * @param ValidationInterface $nextValidation
     * @return mixed
     */
    public function setNext(ValidationInterface $nextValidation): void;
}
