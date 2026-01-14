<?php
declare(strict_types=1);

class BankAccount
{
    private float $balance;

    public function __construct(float $initialBalance = 0)
    {
        if ($initialBalance < 0) {
            throw new InvalidArgumentException("Le solde initial ne peut pas être négatif.");
        }

        $this->balance = $initialBalance;
    }

    public function deposit(float $amount): void
    {
        if ($amount <= 0) {
            throw new InvalidArgumentException("Le montant du dépôt doit être supérieur à 0.");
        }

        $this->balance += $amount;
    }

    public function withdraw(float $amount): void
    {
        if ($amount <= 0) {
            throw new InvalidArgumentException("Le montant du retrait doit être supérieur à 0.");
        }

        if ($amount > $this->balance) {
            throw new RuntimeException("Solde insuffisant.");
        }

        $this->balance -= $amount;
    }

    public function getBalance(): float
    {
        return $this->balance;
    }
}

$account = new BankAccount(100);
$account -> deposit(50);
$account ->withdraw(70);

echo $account->getBalance();