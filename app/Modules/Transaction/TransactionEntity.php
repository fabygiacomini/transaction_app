<?php


namespace App\Modules\Transaction;


use App\Helper\EntityInterface;
use App\Models\Transaction;

class TransactionEntity implements EntityInterface
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $payerId;

    /**
     * @var int
     */
    private $payeeId;

    /**
     * @var float
     */
    private $value;

    /**
     * @var string
     */
    private $dateTime;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getPayerId(): int
    {
        return $this->payerId;
    }

    /**
     * @param int $payerId
     */
    public function setPayerId(int $payerId): void
    {
        $this->payerId = $payerId;
    }

    /**
     * @return int
     */
    public function getPayeeId(): int
    {
        return $this->payeeId;
    }

    /**
     * @param int $payeeId
     */
    public function setPayeeId(int $payeeId): void
    {
        $this->payeeId = $payeeId;
    }

    /**
     * @return float
     */
    public function getValue(): float
    {
        return $this->value;
    }

    /**
     * @param float $value
     */
    public function setValue(float $value): void
    {
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getDateTime(): string
    {
        return $this->dateTime;
    }

    /**
     * @param string $dateTime
     */
    public function setDateTime(string $dateTime): void
    {
        $this->dateTime = $dateTime;
    }


    /**
     * Generate a TransactionEntity from a Transaction (model).
     * @param Transaction $transactionModel
     * @return TransactionEntity
     */
    public static function newEntityFromModel($transactionModel): TransactionEntity
    {
        $transaction = new TransactionEntity();
        $transaction->setId($transactionModel->id);
        $transaction->setPayerId($transactionModel->payer_id);
        $transaction->setPayeeId($transactionModel->payee_id);
        $transaction->setValue($transactionModel->value);
        $transaction->setDateTime(date('d/m/Y H:i:s', strtotime($transactionModel->created_at)));

        return $transaction;
    }
}
