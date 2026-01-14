<?php
declare(strict_types=1);

try {
    // Connexion PDO
    $pdo = new PDO(
        "mysql:host=localhost;dbname=boutique;charset=utf8mb4",
        "dev",     // ou "root"
        "dev",     // ou ""
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]
    );

    // Requête
    $sql = "SELECT * FROM products";
    $stmt = $pdo->query($sql);

    // Récupération des données
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Erreur BDD : " . $e->getMessage());
}

// Protection XSS
function e(string $value): string {
    return htmlspecialchars($value, ENT_QUOTES, "UTF-8");
}
?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Liste des produits</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    .hero {
      background: linear-gradient(135deg, rgba(13,110,253,.12), rgba(108,117,125,.10));
      border: 1px solid rgba(0,0,0,.08);
    }
    .price {
      font-size: 1.15rem;
      font-weight: 700;
      letter-spacing: .2px;
    }
    .card-hover {
      transition: transform .12s ease, box-shadow .12s ease;
    }
    .card-hover:hover {
      transform: translateY(-2px);
      box-shadow: 0 .5rem 1.25rem rgba(0,0,0,.10);
    }
    .muted-small { font-size: .9rem; }
  </style>
</head>

<body class="bg-light">

  <div class="container py-4 py-md-5">

    <!-- Bandeau -->
    <div class="hero rounded-4 p-4 p-md-5 mb-4">
      <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between gap-3">
        <div>
          <h1 class="mb-1">Produits</h1>
          <p class="mb-0 text-secondary">Catalogue chargé depuis la base <span class="fw-semibold">boutique</span>.</p>
        </div>

        <div class="d-flex flex-wrap gap-2">
          <span class="badge text-bg-dark px-3 py-2">
            <?= count($products) ?> produit<?= count($products) > 1 ? "s" : "" ?>
          </span>
          <a class="btn btn-primary" href="recherche.php">Rechercher</a>
          <a class="btn btn-outline-secondary" href="liste-produits.php">Rafraîchir</a>
        </div>
      </div>
    </div>

    <?php if (count($products) === 0): ?>
      <div class="alert alert-warning d-flex align-items-center" role="alert">
        <div class="me-2">⚠️</div>
        <div>Aucun produit dans la base.</div>
      </div>
    <?php else: ?>

      <!-- Grille de cartes -->
      <div class="row g-3 g-md-4">
        <?php foreach ($products as $product): ?>
          <?php
            $stock = (int)$product["stock"];
            $stockLabel = $stock <= 0 ? "Rupture" : ($stock <= 10 ? "Stock faible" : "En stock");
            $stockClass = $stock <= 0 ? "text-bg-danger" : ($stock <= 10 ? "text-bg-warning" : "text-bg-success");
          ?>
          <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
            <div class="card h-100 card-hover shadow-sm">
              <div class="card-body d-flex flex-column">
                <div class="d-flex justify-content-between align-items-start gap-2">
                  <h5 class="card-title mb-1"><?= e($product["name"]) ?></h5>
                  <span class="badge <?= $stockClass ?>"><?= $stockLabel ?></span>
                </div>

                <div class="text-secondary muted-small mb-3">
                  Stock: <span class="fw-semibold"><?= $stock ?></span>
                </div>

                <div class="mt-auto d-flex justify-content-between align-items-center">
                  <div class="price">
                    <?= number_format((float)$product["price"], 2, ",", " ") ?> €
                  </div>

                  <button class="btn btn-outline-primary btn-sm" type="button" disabled
                          title="Bouton déco pour l'exercice">
                    Ajouter
                  </button>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>

    <?php endif; ?>

    <footer class="text-center text-secondary mt-5 small">
      Jour 07 PDO - Liste produits
    </footer>

  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
