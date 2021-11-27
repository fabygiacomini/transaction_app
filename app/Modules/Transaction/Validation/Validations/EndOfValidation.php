<?php


namespace App\Modules\Transaction\Validation;


use App\Modules\User\UserEntity;

class EndOfValidation implements ValidationInterface
{
    // Chain's end
    public function validate(UserEntity $payer, UserEntity $payee, float $transactionValue): bool
    {
        // if the validation check this point, it's becouse none of the
        // validations failed; which means that the transaction can be made
        return true;
    }

    public function setNext(ValidationInterface $nextValidation): void
    {
    }
}
