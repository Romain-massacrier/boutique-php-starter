<?php

class Category
{
    public int $id;
    public string $name;
    public string $description;

    public function __construct(int $id, string $name, string $description)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
    }

    public function getSlug(): string
    {
        return strtolower(str_replace(" ", "-", $this->name));
    }
}

echo "<h2>Test des catégories</h2>";

$cat1 = new Category(1, "Figurines Warhammer", "Toutes les figurines de l'Imperium et du Chaos");
$cat2 = new Category(2, "Véhicules Eldar", "Véhicules rapides et technologiques");
$cat3 = new Category(3, "Monstres Tyranides", "Créatures biologiques de la ruche");

$categories = [$cat1, $cat2, $cat3];

foreach ($categories as $cat) {
    echo "Nom: " . $cat->name . "<br>";
    echo "Slug: " . $cat->getSlug() . "<br>";
    echo "Description: " . $cat->description . "<br>";
    echo "<hr>";
}
