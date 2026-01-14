<?php
declare(strict_types=1);

ini_set('display_errors', '1');
error_reporting(E_ALL);

function e(string $value): string {
    return htmlspecialchars($value, ENT_QUOTES, "UTF-8");
}

try {
    // Connexion PDO
    $pdo = new PDO(
        "mysql:host=localhost;dbname=boutique;charset=utf8mb4",
        "dev",     // ou "root"
        "dev",     // ou ""
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

    // ===== CREATE (AJOUT) =====
    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        $name = trim($_POST["name"] ?? "");
        $description = trim($_POST["description"] ?? "");
        $price = $_POST["price"] ?? "";
        $stock = $_POST["stock"] ?? "";
        $category = trim($_POST["category"] ?? "");

        if ($name === "") {
            die("Erreur : le nom est obligatoire.");
        }
        if (!is_numeric($price)) {
            die("Erreur : prix invalide.");
        }
        if (!is_numeric($stock)) {
            die("Erreur : stock invalide.");
        }

        $stmt = $pdo->prepare(
            "INSERT INTO products (name, description, price, stock, category)
             VALUES (?, ?, ?, ?, ?)"
        );
        $stmt->execute([
            $name,
            $description,
            (float)$price,
            (int)$stock,
            $category
        ]);

        // Redirection pour éviter le repost au refresh
        header("Location: admin-produits.php?added=1");
        exit;
    }

    // ===== READ (LISTE) =====
    $stmt = $pdo->query("SELECT * FROM products ORDER BY id DESC");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Erreur BDD : " . $e->getMessage());
}

// Stats stock
$total = count($products);
$lowStockCount = 0;
$outCount = 0;
foreach ($products as $p) {
    $s = (int)$p["stock"];
    if ($s <= 0) $outCount++;
    elseif ($s <= 10) $lowStockCount++;
}
?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Admin Produits</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    .hero {
      background: linear-gradient(135deg, rgba(13,110,253,.12), rgba(108,117,125,.10));
      border: 1px solid rgba(0,0,0,.08);
    }
    .table td, .table th { vertical-align: middle; }
    .muted-small { font-size: .9rem; }
    .price { font-weight: 700; }
  </style>
</head>

<body class="bg-light">

<div class="container py-4 py-md-5">

  <!-- Header -->
  <div class="hero rounded-4 p-4 p-md-5 mb-4">
    <div class="d-flex flex-column flex-lg-row justify-content-between align-items-start align-items-lg-center gap-3">
      <div>
        <h1 class="mb-1">Administration des produits</h1>
        <div class="text-secondary">Gestion du catalogue</div>
      </div>

      <div class="d-flex flex-wrap gap-2">
        <span class="badge text-bg-dark px-3 py-2">Total: <?= $total ?></span>
        <span class="badge text-bg-warning px-3 py-2">Stock faible: <?= $lowStockCount ?></span>
        <span class="badge text-bg-danger px-3 py-2">Rupture: <?= $outCount ?></span>
        <a class="btn btn-outline-secondary" href="admin-produits.php">Rafraîchir</a>
      </div>
    </div>
  </div>

  <?php if (isset($_GET["added"])): ?>
    <div class="alert alert-success">
      Produit ajouté avec succès.
    </div>
  <?php endif; ?>

  <!-- Table -->
  <div class="card shadow-sm mb-4">
    <div class="card-body p-0">
      <?php if ($total === 0): ?>
        <div class="p-4">
          <div class="alert alert-warning mb-0">Aucun produit.</div>
        </div>
      <?php else: ?>
        <div class="table-responsive">
          <table class="table table-striped table-hover mb-0">
            <thead class="table-dark">
              <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Description</th>
                <th class="text-end">Prix</th>
                <th class="text-end">Stock</th>
                <th>Catégorie</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($products as $product): ?>
                <?php
                  $id = (string)$product["id"];
                  $stock = (int)$product["stock"];
                  $badgeClass = $stock <= 0 ? "text-bg-danger" : ($stock <= 10 ? "text-bg-warning" : "text-bg-success");
                ?>
                <tr>
                  <td><?= e($id) ?></td>
                  <td><?= e((string)$product["name"]) ?></td>
                  <td><?= e((string)($product["description"] ?? "")) ?></td>
                  <td class="text-end"><?= number_format((float)$product["price"], 2, ",", " ") ?> €</td>
                  <td class="text-end">
                    <span class="badge <?= $badgeClass ?>"><?= $stock ?></span>
                  </td>
                  <td><?= e((string)($product["category"] ?? "")) ?></td>
                  <td>
                    <a href="modifier-produit.php?id=<?= e($id) ?>" class="btn btn-sm btn-primary">Modifier</a>
                    <a href="supprimer-produit.php?id=<?= e($id) ?>" class="btn btn-sm btn-danger"
                       onclick="return confirm('Confirmer la suppression ?');">Supprimer</a>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php endif; ?>
    </div>
  </div>

  <!-- Form add -->
  <div class="card shadow-sm">
    <div class="card-header bg-white fw-semibold">
      Ajouter un produit
    </div>
    <div class="card-body">
      <form method="post" class="row g-3">

        <div class="col-md-6">
          <label class="form-label">Nom</label>
          <input type="text" name="name" class="form-control" required>
        </div>

        <div class="col-md-6">
          <label class="form-label">Catégorie</label>
          <input type="text" name="category" class="form-control">
        </div>

        <div class="col-12">
          <label class="form-label">Description</label>
          <textarea name="description" class="form-control"></textarea>
        </div>

        <div class="col-md-4">
          <label class="form-label">Prix (€)</label>
          <input type="number" step="0.01" name="price" class="form-control" required>
        </div>

        <div class="col-md-4">
          <label class="form-label">Stock</label>
          <input type="number" name="stock" class="form-control" required>
        </div>

        <div class="col-md-4 d-flex align-items-end">
          <button type="submit" class="btn btn-success w-100">Ajouter</button>
        </div>

      </form>
    </div>
  </div>

</div>

</body>
</html>
