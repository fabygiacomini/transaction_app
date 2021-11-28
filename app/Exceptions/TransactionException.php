<?php


namespace App\Exceptions;


use Throwable;

/**
 * Class TransactionException
 * Exception used in manipulations involving Transaction
 * @package App\Exceptions
 */
class TransactionException extends \Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
