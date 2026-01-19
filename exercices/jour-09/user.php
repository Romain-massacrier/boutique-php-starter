<?php

class Address
{
    private string $rue;
    private string $ville;
    private string $codePostal;
    private string $pays;

    public function __construct(
        string $rue,
        string $ville,
        string $codePostal,
        string $pays
    ) {
        $this->rue = $rue;
        $this->ville = $ville;
        $this->codePostal = $codePostal;
        $this->pays = $pays;
    }

    public function getRue(): string
    {
        return $this->rue;
    }

    public function getVille(): string
    {
        return $this->ville;
    }

    public function getCodePostal(): string
    {
        return $this->codePostal;
    }

    public function getPays(): string
    {
        return $this->pays;
    }
}


class User
{
    private string $nom;
    private string $email;
    private DateTime $dateInscription;

    
     @var Address[]
     
    private array $addresses = [];

    public function __construct(string $nom, string $email)
    {
        $this->nom = $nom;
        $this->email = $email;
        $this->dateInscription = new DateTime();
    }

    public function addAddress(Address $address): void
    {
        $this->addresses[] = $address;
    }

    public function getAddresses(): array
    {
        return $this->addresses;
    }

    public function getDefaultAddress(): ?Address
    {
        return $this->addresses[0] ?? null;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getDateInscription(): DateTime
    {
        return $this->dateInscription;
    }
}


$user = new User("Romain", "romain@email.fr");

$adresse1 = new Address(
    "10 rue de la Paix",
    "Valence",
    "26000",
    "France"
);

$adresse2 = new Address(
    "5 avenue du Rhône",
    "Lyon",
    "69000",
    "France"
);

$user->addAddress($adresse1);
$user->addAddress($adresse2);

$default = $user->getDefaultAddress();

if ($default !== null) {
    echo $default->getRue() . " - " . $default->getVille();
}
