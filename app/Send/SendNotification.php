<?php


namespace App\Send;


use App\Modules\User\UserEntity;
use Illuminate\Support\Facades\Http;

class SendNotification
{
    public static function notificate(UserEntity $userEntity): bool
    {
        $response = self::send($userEntity);

        $response = json_decode($response, true);

        return $response && $response['message'] == 'Success';
    }

    /**
     * Mock of sending message to payee after transaction.
     * @param UserEntity $userEntity In a real scenery, we would need the user's infos to send notification
     * @return string
     */
    private static function send(UserEntity $userEntity): string
    {
        // Mock the user notification
        return Http::get('http://o4d9z.mocklab.io/notify')->body();
    }
}
