<?php
declare(strict_types=1);

class User
{
    public string $name;
    public string $email;
    public DateTime $registrationDate;

    public function __construct(string $name, string $email, ?DateTime $registrationDate = null)
    {
        $this->name = $name;
        $this->email = $email;

        if ($registrationDate === null) {
            $this->registrationDate = new DateTime();
        } else {
            $this->registrationDate = $registrationDate;
        }
    }

    public function isNewMember(): bool
    {
        $today = new DateTime();
        $interval = $this->registrationDate->diff($today);

        return $interval->days < 30;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getRegistrationDate(): DateTime
    {
        return $this->registrationDate;
    }
}

$user = new User("Romain", "romain@test.fr", new DateTime("2025-12-20"));

echo $user->getName();
var_dump($user->isNewMember());
