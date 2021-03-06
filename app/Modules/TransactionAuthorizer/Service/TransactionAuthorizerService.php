<?php


namespace App\Modules\TransactionAuthorizer\Service;

use App\Modules\TransactionAuthorizer\Repository\TransactionAuthorizerRepositoryInterface;
use App\Modules\User\UserEntity;

class TransactionAuthorizerService implements TransactionAuthorizerServiceInterface
{
    /**
     * @var TransactionAuthorizerRepositoryInterface
     */
    private $authorizerRepository;

    public function __construct(TransactionAuthorizerRepositoryInterface $authorizerRepository)
    {
        $this->authorizerRepository = $authorizerRepository;
    }

    /**
     * @inheritDoc
     */
    public function verifyAuthorizator(UserEntity $userEntity, float $value): ?string
    {
        $response = $this->authorizerRepository->verifyAuthorizator($userEntity, $value);
        return $response ? json_decode($response, true)['message'] : null;
    }
}
