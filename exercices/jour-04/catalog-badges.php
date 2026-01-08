<?php

$products = [
    [
        "name" => "Famicom",
        "price" => 39.99,
        "stock" => 12,
        "new" => true,
        "discount" => 10,
        "image" => "https://upload.wikimedia.org/wikipedia/commons/thumb/4/4c/Nintendo-Famicom-Console-Set-FL.png/330px-Nintendo-Famicom-Console-Set-FL.png",
        "description" => "La console mythique de Nintendo qui a marqué le début du jeu vidéo familial."
    ],
    [
        "name" => "Super Famicom Jr",
        "price" => 139.99,
        "stock" => 52,
        "new" => false,
        "image" => "https://upload.wikimedia.org/wikipedia/commons/e/e3/SuperFamicom_jr.jpg",
        "description" => "Version compacte de la Super Famicom offrant des classiques 16 bits inoubliables."
    ],
    [
        "name" => "PC Engine",
        "price" => 99.99,
        "stock" => 4,
        "new" => false,
        "image" => "https://upload.wikimedia.org/wikipedia/commons/5/5a/PC_Engine.jpg",
        "description" => "Console culte au design minimaliste, célèbre pour ses jeux arcade de qualité."
    ],
    [
        "name" => "Neo Geo AES",
        "price" => 499.99,
        "stock" => 0,
        "new" => true,
        "image" => "https://upload.wikimedia.org/wikipedia/commons/5/59/Neogeoaes.jpg",
        "description" => "La console de luxe des années 90, identique aux bornes d’arcade SNK."
    ],
    [
        "name" => "Playdia",
        "price" => 119.99,
        "stock" => 1,
        "new" => false,
        "image" => "https://upload.wikimedia.org/wikipedia/commons/thumb/7/74/Playdia-Console-Set.png/2560px-Playdia-Console-Set.png",
        "description" => "Console atypique de Bandai orientée jeux interactifs et multimédia."
    ],
    [
        "name" => "Twin Famicom",
        "price" => 99.99,
        "stock" => 9,
        "new" => true,
        "image" => "https://upload.wikimedia.org/wikipedia/commons/thumb/2/26/Sharp-Twin-Famicom-Console.png/2560px-Sharp-Twin-Famicom-Console.png",
        "description" => "Console hybride combinant cartouches et disquettes Famicom."
    ],
    [
        "name" => "Megadrive",
        "price" => 69.99,
        "stock" => 26,
        "new" => false,
        "image" => "https://upload.wikimedia.org/wikipedia/commons/thumb/b/b8/Sega-Mega-Drive-EU-Mk1-wController-FL.png/2560px-Sega-Mega-Drive-EU-Mk1-wController-FL.png",
        "description" => "La console emblématique de SEGA, connue pour sa vitesse et ses jeux d’action."
    ],
    [
        "name" => "Nintendo 64",
        "price" => 89.99,
        "stock" => 15,
        "new" => true,
        "image" => "https://upload.wikimedia.org/wikipedia/commons/thumb/0/02/N64-Console-Set.png/2560px-N64-Console-Set.png",
        "description" => "Console révolutionnaire qui a popularisé la 3D dans les jeux vidéo."
    ],
];

// Stats
$inStock = 0;
$onSale = 0;
$outOfStock = 0;

foreach ($products as $product) {
    $discount = (int)($product["discount"] ?? 0);
    if ($product["stock"] > 0) $inStock++;
    if ($discount > 0) $onSale++;
    if ($product["stock"] === 0) $outOfStock++;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Catalogue</title>

<style>
body{
  font-family: Arial, sans-serif;
  background: #f4f4f4;
  margin: 0;
  padding: 30px;
}

.stats{
  margin-bottom: 25px;
  padding: 15px;
  background: #fff;
  border-radius: 10px;
  box-shadow: 0 1px 6px rgba(0,0,0,.08);
}

.grille{
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 20px;
}

.produit{
  background: #fff;
  padding: 15px;
  border-radius: 10px;
  box-shadow: 0 1px 6px rgba(0,0,0,.08);
  display: flex;
  flex-direction: column;
}

.produit h2{
  margin: 0 0 6px;
  min-height: 56px;
}

.badges{
  display: flex;
  gap: 8px;
  flex-wrap: wrap;
  min-height: 24px;
  margin-bottom: 10px;
}

.badge{
  padding: 4px 8px;
  font-size: 12px;
  font-weight: bold;
  border-radius: 999px;
  color: #fff;
}

.badge.new{ background: #2b9348; }
.badge.promo{ background: #d90429; }
.badge.last{ background: #ff9f1c; color: #111; }

.produit img{
  width: 100%;
  height: 180px;
  object-fit: contain;
  margin: 10px 0;
}

.description{
  font-size: 13px;
  color: #444;
  min-height: 48px;
}

.price-line{
  margin: 10px 0;
  display: flex;
  align-items: center;
  gap: 8px;
}

.price-old{
  text-decoration: line-through;
  color: #888;
}

.price-new{
  color: #d90429;
  font-size: 18px;
  font-weight: bold;
}

.price{
  font-size: 16px;
  font-weight: bold;
}

.en-stock{ color: green; font-weight: bold; }
.rupture{ color: red; font-weight: bold; }

.btn{
  margin-top: auto;
  padding: 10px;
  border: none;
  border-radius: 8px;
  cursor: pointer;
}

.btn.add{
  background: #111;
  color: #fff;
}

.btn.add[disabled]{
  background: #bbb;
  cursor: not-allowed;
}
</style>
</head>

<body>

<div class="stats">
  <strong>Stats</strong><br>
  Produits en stock : <?= $inStock ?><br>
  Produits en promo : <?= $onSale ?><br>
  Ruptures : <?= $outOfStock ?>
</div>

<div class="grille">
<?php foreach ($products as $product): ?>
<?php
$discount = (int)($product["discount"] ?? 0);
$isNew = $product["new"] ?? false;
$isPromo = $discount > 0;
$isLast = $product["stock"] > 0 && $product["stock"] < 5;
$finalPrice = $isPromo ? $product["price"] * (1 - $discount / 100) : $product["price"];
?>
<div class="produit">
  <h2><?= $product["name"] ?></h2>

  <div class="badges">
    <?= $isNew ? '<span class="badge new">NOUVEAU</span>' : '' ?>
    <?= $isPromo ? '<span class="badge promo">PROMO -'.$discount.'%</span>' : '' ?>
    <?= $isLast ? '<span class="badge last">DERNIERS</span>' : '' ?>
  </div>

  <img src="<?= $product["image"] ?>" alt="<?= htmlspecialchars($product["name"]) ?>">

  <p class="description"><?= $product["description"] ?></p>

  <div class="price-line">
    <?php if ($isPromo): ?>
      <span class="price-old"><?= number_format($product["price"], 2, ",", " ") ?> €</span>
      <span class="price-new"><?= number_format($finalPrice, 2, ",", " ") ?> €</span>
    <?php else: ?>
      <span class="price"><?= number_format($product["price"], 2, ",", " ") ?> €</span>
    <?php endif; ?>
  </div>

  <?php if ($product["stock"] > 0): ?>
    <p class="en-stock">En stock (<?= $product["stock"] ?>)</p>
  <?php else: ?>
    <p class="rupture">RUPTURE</p>
  <?php endif; ?>

  <button class="btn add" <?= $product["stock"] > 0 ? "" : "disabled" ?>>
    Ajouter au panier
  </button>
</div>
<?php endforeach; ?>
</div>

</body>
</html>
