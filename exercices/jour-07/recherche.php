<?php
declare(strict_types=1);

ini_set('display_errors', '1');
error_reporting(E_ALL);

try {
    $pdo = new PDO(
        "mysql:host=localhost;dbname=boutique;charset=utf8mb4",
        "dev",     // ou "root"
        "dev",     // ou ""
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

    $search = $_GET["search"] ?? "";
    $search = trim($search);

    $results = [];

    if ($search !== "") {
        $sql = "SELECT * FROM products WHERE name LIKE ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(["%" . $search . "%"]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

} catch (PDOException $e) {
    die("Erreur BDD : " . $e->getMessage());
}

function e(string $value): string {
    return htmlspecialchars($value, ENT_QUOTES, "UTF-8");
}
?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Recherche produits</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap -->
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
    <div class="d-flex flex-column flex-lg-row align-items-start align-items-lg-center justify-content-between gap-3">
      <div>
        <h1 class="mb-1">Recherche de produits</h1>
        <p class="mb-0 text-secondary">Tape un nom (ex: <span class="fw-semibold">Jean</span>, <span class="fw-semibold">Sac</span>, <span class="fw-semibold">T-shirt</span>).</p>
      </div>

      <div class="d-flex flex-wrap gap-2">
        <a class="btn btn-outline-secondary" href="recherche.php">Réinitialiser</a>
        <a class="btn btn-primary" href="liste-produits.php">Voir tout</a>
      </div>
    </div>

    <!-- Formulaire de recherche -->
    <form class="mt-4" method="get">
      <div class="row g-2 align-items-center">
        <div class="col-12 col-md-8 col-lg-6">
          <div class="input-group input-group-lg">
            <span class="input-group-text">🔎</span>
            <input
              type="text"
              class="form-control"
              name="search"
              placeholder="Nom du produit"
              value="<?= e($search) ?>"
            >
          </div>
        </div>
        <div class="col-12 col-md-auto">
          <button class="btn btn-lg btn-success" type="submit">Rechercher</button>
        </div>

        <?php if ($search !== ""): ?>
          <div class="col-12">
            <div class="mt-2 text-secondary">
              Résultats pour : <span class="fw-semibold">"<?= e($search) ?>"</span>
              <span class="badge text-bg-dark ms-2">
                <?= count($results) ?> trouvé<?= count($results) > 1 ? "s" : "" ?>
              </span>
            </div>
          </div>
        <?php endif; ?>
      </div>
    </form>
  </div>

  <!-- Contenu -->
  <?php if ($search === ""): ?>

    <div class="alert alert-info">
      Commence par taper un mot clé dans la barre de recherche.
    </div>

  <?php else: ?>

    <?php if (count($results) === 0): ?>
      <div class="alert alert-warning d-flex align-items-center" role="alert">
        <div class="me-2">⚠️</div>
        <div>Aucun produit trouvé.</div>
      </div>
    <?php else: ?>

      <div class="row g-3 g-md-4">
        <?php foreach ($results as $product): ?>
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

  <?php endif; ?>

  <footer class="text-center text-secondary mt-5 small">
    Jour 07 PDO - Recherche produits
  </footer>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
