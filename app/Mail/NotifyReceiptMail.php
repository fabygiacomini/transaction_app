<?php

namespace App\Mail;

use App\Modules\Transaction\TransactionEntity;
use App\Modules\User\UserEntity;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotifyReceiptMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var UserEntity
     */
    private $payee;

    /**
     * @var UserEntity
     */
    private $payer;

    /**
     * @var TransactionEntity
     */
    private $transaction;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(UserEntity $payee, UserEntity $payer, TransactionEntity $transaction)
    {
        $this->payee = $payee;
        $this->payer = $payer;
        $this->transaction = $transaction;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown(
            'emails.receipt',
            [
                'payee' => $this->payee->getName(),
                'payer' => $this->payer->getName(),
                'value' => $this->transaction->getValue(),
                'date' => $this->transaction->getDateTime()
            ]
        );
    }
}
