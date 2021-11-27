<?php


namespace App\Modules\TransactionAuthorizer\Repository;


use App\Modules\User\UserEntity;

interface TransactionAuthorizerRepositoryInterface
{
    /**
     * Verify the authorization to make the transaction is an external service
     * @param UserEntity $userEntity
     * @param float $value
     * @return string
     */
    public function verifyAuthorizator(UserEntity $userEntity, float $value): ?string;
}
