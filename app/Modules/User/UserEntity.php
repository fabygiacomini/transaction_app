<?php


namespace App\Modules\User;


use App\Helper\EntityInterface;
use App\Models\User;

class UserEntity implements EntityInterface
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $password;

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @var integer
     */
    private $cpfCnpj;

    /**
     * @var boolean
     */
    private $shopkeeper;

    /**
     * @var float
     */
    private $balance;

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
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return int
     */
    public function getCpfCnpj(): int
    {
        return $this->cpfCnpj;
    }

    /**
     * @param int $cpfCnpj
     */
    public function setCpfCnpj(int $cpfCnpj): void
    {
        $this->cpfCnpj = $cpfCnpj;
    }

    /**
     * @return bool
     */
    public function isShopkeeper(): bool
    {
        return $this->shopkeeper;
    }

    /**
     * @param bool $shopkeeper
     */
    public function setShopkeeper(bool $shopkeeper): void
    {
        $this->shopkeeper = $shopkeeper;
    }

    /**
     * @return float
     */
    public function getBalance(): float
    {
        return $this->balance;
    }

    /**
     * @param float $balance
     */
    public function setBalance(float $balance): void
    {
        $this->balance = $balance;
    }


    /**
     * @param User $userModel
     * @return EntityInterface
     */
    public static function newEntityFromModel($userModel): ?UserEntity
    {
        if (!$userModel) {
            return null;
        }

        $userEntity = new UserEntity();
        $userEntity->setId($userModel->id);
        $userEntity->setName($userModel->name);
        $userEntity->setCpfCnpj($userModel->cpf_cnpj);
        $userEntity->setEmail($userModel->email);
        $userEntity->setShopkeeper($userModel->shopkeeper);

        if ($userModel->wallet) {
            $userEntity->setBalance($userModel->wallet->balance);
        }

        return $userEntity;
    }
}
