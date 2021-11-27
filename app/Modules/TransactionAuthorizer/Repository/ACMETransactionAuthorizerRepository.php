<?php


namespace App\Modules\TransactionAuthorizer\Repository;


use App\Modules\TransactionAuthorization\Repository\TransactionAuthorizerRepositoryInterface;
use App\Modules\User\UserEntity;

class ACMETransactionAuthorizerRepository implements TransactionAuthorizerRepositoryInterface
{

    public function verifyAuthorizator(UserEntity $userEntity, float $value): ?string
    {
        // Done by PHP Curl, but the same can be done with Guzzle
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6");

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $output = curl_exec($ch);
        curl_close($ch);

        return $output;
    }
}
