<?php

require 'ProductRepository.php';

// Connexion PDO (exemple)
$pdo = new PDO(
    'mysql:host=localhost;dbname=boutique;charset=utf8',
    'boutique',
    'boutique123',
    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
);


$repo = new ProductRepository($pdo);

echo "<h3>TEST CRUD</h3>";

// 1) CREATE
$product = [
    'name' => 'Produit test',
    'price' => 10.0
];

$id = $repo->save($product);
echo $id ? "CREATE OK (id = $id)<br>" : "CREATE ERREUR<br>";

// 2) READ (vérification création)
$created = $repo->find($id);
echo $created ? "READ OK<br>" : "READ ERREUR<br>";

// 3) UPDATE
$repo->update($id, [
    'name' => 'Produit modifié',
    'price' => 20.0
]);

$updated = $repo->find($id);
echo ($updated && $updated['price'] == 20.0)
    ? "UPDATE OK<br>"
    : "UPDATE ERREUR<br>";

// 4) DELETE
$repo->delete($id);
$deleted = $repo->find($id);

echo $deleted === null
    ? "DELETE OK<br>"
    : "DELETE ERREUR<br>";
