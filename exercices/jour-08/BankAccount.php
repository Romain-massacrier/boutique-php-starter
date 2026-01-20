<?php

// Déclaration de la classe BankAccount
class BankAccount {

    // Propriété privée qui stocke le solde du compte
    // private = accessible uniquement depuis la classe
    private $balance;

    // Constructeur : méthode appelée automatiquement
    // quand on crée un nouvel objet BankAccount
    public function __construct() {
        // Initialisation du solde à 0
        $this->balance = 0;
    }

    // Méthode pour déposer de l'argent sur le compte
    public function deposit($amount) {

        // Vérifie que le montant est positif
        if ($amount <= 0) {
            echo "Erreur : le montant doit être positif.\n";
            return; // On arrête la méthode
        }

        // Ajoute le montant au solde actuel
        $this->balance = $this->balance + $amount;

        // Message de confirmation
        echo "Dépôt de $amount effectué.\n";
    }

    // Méthode pour retirer de l'argent du compte
    public function withdraw($amount) {

        // Vérifie que le montant est positif
        if ($amount <= 0) {
            echo "Erreur : le montant doit être positif.\n";
            return;
        }

        // Vérifie si le solde est suffisant
        if ($amount > $this->balance) {
            echo "Erreur : solde insuffisant.\n";
            return;
        }

        // Retire le montant du solde
        $this->balance = $this->balance - $amount;

        // Message de confirmation
        echo "Retrait de $amount effectué.\n";
    }

    // Méthode qui retourne le solde actuel
    public function getBalance() {
        return $this->balance;
    }
}

// Création d'un objet BankAccount
$compte = new BankAccount();

// Dépôt de 100 sur le compte
$compte->deposit(100);

// Retrait de 30
$compte->withdraw(30);

// Affichage du solde actuel
echo "Solde actuel : " . $compte->getBalance() . "\n";

// Tentative de retrait de 80
// Le solde est insuffisant, donc l'opération échoue volontairement
$compte->withdraw(80);

?>
