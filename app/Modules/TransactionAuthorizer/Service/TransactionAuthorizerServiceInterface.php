<?php


namespace App\Modules\TransactionAuthorizer\Service;

use App\Modules\TransactionAuthorizer\Repository\TransactionAuthorizerRepositoryInterface;
use App\Modules\User\UserEntity;

interface TransactionAuthorizerServiceInterface
{

    public function __construct(TransactionAuthorizerRepositoryInterface $authorizerRepository);

    /**
     * Verify the authorization to make the transaction is an external service
     * @param UserEntity $userEntity
     * @param float $value
     * @return string
     */
    public function verifyAuthorizator(UserEntity $userEntity, float $value): ?string;
}
