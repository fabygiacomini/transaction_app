<?php


namespace App\Exceptions;


use Throwable;

/**
 * Class UserException
 * Exception used in manipulations involving User and his Wallet
 * @package App\Exceptions
 */
class UserException extends \Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
