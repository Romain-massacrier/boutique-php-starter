<?php


class Address
{
    // Nom de la rue
    private string $rue;

    // Ville
    private string $ville;

    // Code postal
    private string $codePostal;

    // Pays
    private string $pays;

    // Constructeur de l'adresse
    public function __construct(
        string $rue,
        string $ville,
        string $codePostal,
        string $pays
    ) {
        // Initialisation des propriétés
        $this->rue = $rue;
        $this->ville = $ville;
        $this->codePostal = $codePostal;
        $this->pays = $pays;
    }

    // Retourne la rue
    public function getRue(): string
    {
        return $this->rue;
    }

    // Retourne la ville
    public function getVille(): string
    {
        return $this->ville;
    }

    // Retourne le code postal
    public function getCodePostal(): string
    {
        return $this->codePostal;
    }

    // Retourne le pays
    public function getPays(): string
    {
        return $this->pays;
    }
}

class User
{
    // Nom de l'utilisateur
    private string $nom;

    // Email de l'utilisateur
    private string $email;

    // Date d'inscription de l'utilisateur
    private DateTime $dateInscription;

    /**
     * Tableau des adresses de l'utilisateur
     * @var Address[]
     */
    private array $addresses = [];

    // Constructeur du User
    public function __construct(string $nom, string $email)
    {
        // Initialisation des propriétés
        $this->nom = $nom;
        $this->email = $email;

        // Date d'inscription définie automatiquement
        $this->dateInscription = new DateTime();
    }

    // Ajoute une adresse à l'utilisateur
    public function addAddress(Address $address): void
    {
        $this->addresses[] = $address;
    }

    // Retourne toutes les adresses
    public function getAddresses(): array
    {
        return $this->addresses;
    }

    // Retourne l'adresse par défaut
    // Ici, on considère que c'est la première ajoutée
    public function getDefaultAddress(): ?Address
    {
        // Retourne null s'il n'y a aucune adresse
        return $this->addresses[0] ?? null;
    }

    // Retourne le nom
    public function getNom(): string
    {
        return $this->nom;
    }

    // Retourne l'email
    public function getEmail(): string
    {
        return $this->email;
    }

    // Retourne la date d'inscription
    public function getDateInscription(): DateTime
    {
        return $this->dateInscription;
    }
}


// Création d'un utilisateur
$user = new User("Romain", "romain@email.fr");

// Création de deux adresses
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

// Ajout des adresses à l'utilisateur
$user->addAddress($adresse1);
$user->addAddress($adresse2);

// Récupération de l'adresse par défaut
$default = $user->getDefaultAddress();

// Vérification avant affichage
if ($default !== null) {
    echo $default->getRue() . " - " . $default->getVille();
}
