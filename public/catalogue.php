<?php
// starter-project/public/catalogue.php

session_start();

require_once __DIR__ . "/../app/Entity/Product.php";
require_once __DIR__ . "/../app/data.php";     // $products (objets Product), $games (tableaux)
require_once __DIR__ . "/../app/helpers.php";  // formatPrice, calculateIncludingTax, calculateDiscount

use App\Entity\Product;

// Panier
if (!isset($_SESSION["cart"]) || !is_array($_SESSION["cart"])) {
    $_SESSION["cart"] = [];
}

// Vue
$view = (string)($_GET["view"] ?? "consoles"); // "consoles" | "jeux"
if (!in_array($view, ["consoles", "jeux"], true)) {
    $view = "consoles";
}

// Recherche
$q = trim((string)($_GET["q"] ?? ""));

// Filtres existants (inchangés)
$status = (string)($_GET["status"] ?? "");               // consoles: "", "en_stock", "rupture", "promo", "new"
$consoleFilter = trim((string)($_GET["console"] ?? "")); // jeux
$categoryFilter = trim((string)($_GET["cat"] ?? ""));    // jeux

// Helpers
function matchesSearch(string $text, string $q): bool {
    if ($q === "") return true;
    return mb_stripos($text, $q) !== false;
}

function getGameCategory(array $g): string {
    if (isset($g["genre"]) && is_string($g["genre"]) && trim($g["genre"]) !== "") return trim($g["genre"]);
    if (isset($g["category"]) && is_string($g["category"]) && trim($g["category"]) !== "") return trim($g["category"]);
    return (string)($g["console"] ?? "Inconnu");
}

// Listes pour selects
$allConsoles = [];
foreach ($products as $p) {
    if ($p instanceof Product) {
        $allConsoles[] = $p->getName();
    }
}
$allConsoles = array_values(array_unique(array_filter($allConsoles, fn($c) => $c !== "")));
sort($allConsoles);

$allGameCategories = [];
foreach ($games as $g) {
    $allGameCategories[] = getGameCategory($g);
}
$allGameCategories = array_values(array_unique(array_filter($allGameCategories, fn($c) => $c !== "")));
sort($allGameCategories);

// Ajout panier (console OU jeu)
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["add_to_cart"])) {
    $type = (string)($_POST["type"] ?? "product");
    $index = (int)($_POST["index"] ?? -1);

    if ($type === "product" && isset($products[$index]) && $products[$index] instanceof Product) {
        $p = $products[$index];

        $_SESSION["cart"][] = [
            "name" => $p->getName(),
            "price" => $p->getPrice(),
            "discount" => (float)$p->getDiscount(),
            "vat" => 20.0
        ];
    }

    if ($type === "game" && isset($games[$index])) {
        $g = $games[$index];
        $_SESSION["cart"][] = [
            "name" => (string)($g["name"] ?? "Jeu"),
            "price" => (float)($g["price"] ?? 0),
            "discount" => 0.0,
            "vat" => 20.0
        ];
    }

    $qs = $_GET;
    $redirect = $_SERVER["PHP_SELF"] . (count($qs) ? ("?" . http_build_query($qs)) : "");
    header("Location: " . $redirect);
    exit;
}

// Vider le panier
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["clear_cart"])) {
    $_SESSION["cart"] = [];
    $qs = $_GET;
    $redirect = $_SERVER["PHP_SELF"] . (count($qs) ? ("?" . http_build_query($qs)) : "");
    header("Location: " . $redirect);
    exit;
}

// Stats consoles
$inStock = 0;
$onSale = 0;
$outOfStock = 0;

foreach ($products as $product) {
    if (!($product instanceof Product)) continue;

    $discount = (float)$product->getDiscount();
    $stock = (int)$product->getStock();

    if ($stock > 0) $inStock++;
    if ($discount > 0) $onSale++;
    if ($stock === 0) $outOfStock++;
}

// Total panier
$cartTotal = 0.0;
foreach ($_SESSION["cart"] as $item) {
    $ttc = calculateIncludingTax((float)$item["price"], (float)$item["vat"]);
    $final = ((float)$item["discount"] > 0) ? calculateDiscount($ttc, (float)$item["discount"]) : $ttc;
    $cartTotal += $final;
}

// Filtres consoles (objets Product)
$filteredProducts = array_filter($products, function($p) use ($q, $status) {
    if (!($p instanceof Product)) return false;

    $name = $p->getName();
    $stock = (int)$p->getStock();
    $discount = (float)$p->getDiscount();
    $isNew = (bool)$p->isNew();

    if (!matchesSearch($name, $q)) return false;

    if ($status === "en_stock" && $stock <= 0) return false;
    if ($status === "rupture" && $stock !== 0) return false;
    if ($status === "promo" && $discount <= 0) return false;
    if ($status === "new" && !$isNew) return false;

    return true;
});

// Filtres jeux (tableaux)
$filteredGames = array_filter($games, function($g) use ($q, $consoleFilter, $categoryFilter) {
    $name = (string)($g["name"] ?? "");
    $console = (string)($g["console"] ?? "");
    $cat = getGameCategory($g);

    if (!matchesSearch($name, $q)) return false;
    if ($consoleFilter !== "" && $console !== $consoleFilter) return false;
    if ($categoryFilter !== "" && $cat !== $categoryFilter) return false;

    return true;
});

// Regrouper les jeux par console
$gamesByConsole = [];
foreach ($filteredGames as $idx => $g) {
    $console = (string)($g["console"] ?? "Inconnu");
    if (!isset($gamesByConsole[$console])) $gamesByConsole[$console] = [];
    $gamesByConsole[$console][] = ["idx" => $idx, "game" => $g];
}
ksort($gamesByConsole);

// Petites fonctions de rendu
function stockClass(int $stock): string {
    if ($stock <= 0) return "product-card__stock--out";
    if ($stock <= 3) return "product-card__stock--low";
    return "product-card__stock--available";
}
function stockText(int $stock): string {
    if ($stock <= 0) return "✗ Rupture";
    if ($stock <= 3) return "⚠ Plus que " . $stock;
    return "✓ En stock (" . $stock . ")";
}
function renderBadgesForProduct(Product $p): string {
    $stock = (int)$p->getStock();
    $discount = (float)$p->getDiscount();
    $isNew = (bool)$p->isNew();

    $out = [];
    if ($isNew) $out[] = '<span class="badge badge--new">Nouveau</span>';
    if ($discount > 0) $out[] = '<span class="badge badge--promo">-' . (int)$discount . '%</span>';
    if ($stock > 0 && $stock <= 3) $out[] = '<span class="badge badge--low-stock">Derniers</span>';
    if ($stock <= 0) $out[] = '<span class="badge badge--out-of-stock">Rupture</span>';

    return implode("", $out);
}
function priceParts(float $priceHT, float $vat, float $discount): array {
    $ttc = calculateIncludingTax($priceHT, $vat);
    $hasDiscount = $discount > 0;
    $final = $hasDiscount ? calculateDiscount($ttc, $discount) : $ttc;
    return [$ttc, $final, $hasDiscount];
}

$foundCount = ($view === "consoles") ? count($filteredProducts) : count($filteredGames);
$cartCount = count($_SESSION["cart"]);
?>
<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Catalogue - MaBoutique</title>
    <link rel="stylesheet" href="css/style.css" />
  </head>
  <body>
    <header class="header">
      <div class="container header__container">
        <a href="index.php" class="header__logo">🛍️ MaBoutique</a>

        <nav class="header__nav">
          <a href="index.php" class="header__nav-link">Accueil</a>
          <a href="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>?view=<?= htmlspecialchars($view) ?>" class="header__nav-link header__nav-link--active">Catalogue</a>
          <a href="contact.php" class="header__nav-link">Contact</a>
        </nav>

        <div class="header__actions">
          <a href="panier.php" class="header__cart">
            🛒<span class="header__cart-badge"><?= (int)$cartCount ?></span>
          </a>
          <a href="connexion.php" class="btn btn--primary btn--sm">Connexion</a>
        </div>

        <button class="header__menu-toggle">☰</button>
      </div>
    </header>

    <main class="main-content">
      <div class="container">
        <div class="page-header">
          <h1 class="page-title">Notre Catalogue</h1>
          <p class="page-subtitle">
            <?= $view === "consoles" ? "Consoles" : "Jeux par console" ?>
            <span style="opacity:.7">
              (en stock: <?= (int)$inStock ?>, promo: <?= (int)$onSale ?>, rupture: <?= (int)$outOfStock ?>)
            </span>
          </p>
        </div>

        <div class="catalog-layout">
          <aside class="catalog-sidebar">
            <form method="get" action="">
              <input type="hidden" name="view" value="<?= htmlspecialchars($view) ?>">

              <div class="catalog-sidebar__section">
                <h3 class="catalog-sidebar__title">Recherche</h3>
                <input
                  type="text"
                  name="q"
                  class="form-input"
                  placeholder="Rechercher..."
                  value="<?= htmlspecialchars($q) ?>"
                />
              </div>

              <div class="catalog-sidebar__section">
                <h3 class="catalog-sidebar__title">Affichage</h3>
                <div class="catalog-sidebar__categories">
                  <label class="form-checkbox">
                    <input type="radio" name="view" value="consoles" <?= $view === "consoles" ? "checked" : "" ?> />
                    <span>Consoles</span>
                  </label>
                  <label class="form-checkbox">
                    <input type="radio" name="view" value="jeux" <?= $view === "jeux" ? "checked" : "" ?> />
                    <span>Jeux par console</span>
                  </label>
                </div>
              </div>

              <?php if ($view === "consoles"): ?>
                <div class="catalog-sidebar__section">
                  <h3 class="catalog-sidebar__title">Filtre consoles</h3>
                  <select class="form-select" name="status">
                    <option value="" <?= $status === "" ? "selected" : "" ?>>Toutes</option>
                    <option value="en_stock" <?= $status === "en_stock" ? "selected" : "" ?>>En stock</option>
                    <option value="promo" <?= $status === "promo" ? "selected" : "" ?>>En promo</option>
                    <option value="new" <?= $status === "new" ? "selected" : "" ?>>Nouveautés</option>
                    <option value="rupture" <?= $status === "rupture" ? "selected" : "" ?>>Rupture</option>
                  </select>
                </div>
              <?php else: ?>
                <div class="catalog-sidebar__section">
                  <h3 class="catalog-sidebar__title">Filtre jeux</h3>

                  <div class="form-group" style="margin-bottom:12px;">
                    <label class="form-label">Console</label>
                    <select class="form-select" name="console">
                      <option value="" <?= $consoleFilter === "" ? "selected" : "" ?>>Toutes les consoles</option>
                      <?php foreach ($allConsoles as $c): ?>
                        <option value="<?= htmlspecialchars($c) ?>" <?= $consoleFilter === $c ? "selected" : "" ?>>
                          <?= htmlspecialchars($c) ?>
                        </option>
                      <?php endforeach; ?>
                    </select>
                  </div>

                  <div class="form-group">
                    <label class="form-label">Catégorie</label>
                    <select class="form-select" name="cat">
                      <option value="" <?= $categoryFilter === "" ? "selected" : "" ?>>Toutes les catégories</option>
                      <?php foreach ($allGameCategories as $cat): ?>
                        <option value="<?= htmlspecialchars($cat) ?>" <?= $categoryFilter === $cat ? "selected" : "" ?>>
                          <?= htmlspecialchars($cat) ?>
                        </option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                </div>
              <?php endif; ?>

              <button type="submit" class="btn btn--primary btn--block">Appliquer</button>
              <a
                href="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>?view=<?= htmlspecialchars($view) ?>"
                class="btn btn--secondary btn--block mt-sm"
              >Réinitialiser</a>

              <div class="catalog-sidebar__section" style="margin-top:16px;">
                <h3 class="catalog-sidebar__title">Panier</h3>

                <?php if ($cartCount === 0): ?>
                  <p style="opacity:.8;margin:0;">Panier vide</p>
                <?php else: ?>
                  <ul style="margin:0;padding-left:18px;">
                    <?php foreach ($_SESSION["cart"] as $item): ?>
                      <li style="margin:6px 0;">
                        <?= htmlspecialchars((string)$item["name"]) ?>
                        <span style="opacity:.75;font-size:.95em;">
                          (<?= formatPrice(calculateIncludingTax((float)$item["price"], (float)$item["vat"])) ?>)
                        </span>
                      </li>
                    <?php endforeach; ?>
                  </ul>

                  <p style="margin:10px 0 0;">
                    <strong>Total:</strong> <?= formatPrice($cartTotal) ?>
                  </p>

                  <form method="post" style="margin-top:10px;">
                    <button type="submit" name="clear_cart" class="btn btn--secondary btn--block">Vider le panier</button>
                  </form>
                <?php endif; ?>
              </div>
            </form>
          </aside>

          <div class="catalog-main">
            <div class="catalog-header">
              <p><strong><?= (int)$foundCount ?></strong> élément(s) trouvé(s)</p>
              <div class="catalog-header__sort">
                <label>Trier :</label>
                <select class="form-select" style="width: auto" disabled>
                  <option>Nom A-Z</option>
                  <option>Nom Z-A</option>
                  <option>Prix ↑</option>
                  <option>Prix ↓</option>
                </select>
              </div>
            </div>

            <?php if ($view === "consoles"): ?>
              <div class="products-grid">
                <?php foreach ($filteredProducts as $i => $product): ?>
                  <?php
                    if (!($product instanceof Product)) continue;

                    $name = $product->getName();
                    $img = $product->getImage();
                    $desc = $product->getDescription();
                    $stock = (int)$product->getStock();
                    $discount = (float)$product->getDiscount();

                    [$ttc, $final, $hasDiscount] = priceParts((float)$product->getPrice(), 20.0, $discount);
                  ?>
                  <article class="product-card">
                    <div class="product-card__image-wrapper">
                      <img
                        src="<?= htmlspecialchars($img) ?>"
                        alt="<?= htmlspecialchars($name) ?>"
                        class="product-card__image"
                      />
                      <div class="product-card__badges">
                        <?= renderBadgesForProduct($product) ?>
                      </div>
                    </div>

                    <div class="product-card__content">
                      <span class="product-card__category">Console</span>

                      <a href="#" class="product-card__title">
                        <?= htmlspecialchars($name) ?>
                      </a>

                      <div class="product-card__price">
                        <?php if ($hasDiscount): ?>
                          <span class="product-card__price-current"><?= formatPrice($final) ?></span>
                          <span class="product-card__price-old"><?= formatPrice($ttc) ?></span>
                        <?php else: ?>
                          <span class="product-card__price-current"><?= formatPrice($final) ?></span>
                        <?php endif; ?>
                      </div>

                      <?php if ($desc !== ""): ?>
                        <p style="margin:8px 0 10px;opacity:.85;">
                          <?= htmlspecialchars($desc) ?>
                        </p>
                      <?php endif; ?>

                      <p class="product-card__stock <?= htmlspecialchars(stockClass($stock)) ?>">
                        <?= htmlspecialchars(stockText($stock)) ?>
                      </p>

                      <div class="product-card__actions">
                        <form method="post" style="margin:0;">
                          <input type="hidden" name="type" value="product">
                          <input type="hidden" name="index" value="<?= (int)$i ?>">
                          <button
                            type="submit"
                            name="add_to_cart"
                            class="btn btn--primary btn--block"
                            <?= $stock <= 0 ? "disabled" : "" ?>
                          >Ajouter</button>
                        </form>
                      </div>
                    </div>
                  </article>
                <?php endforeach; ?>
              </div>

            <?php else: ?>

              <?php if (count($gamesByConsole) === 0): ?>
                <p style="opacity:.8;">Aucun jeu ne correspond à tes filtres.</p>
              <?php endif; ?>

              <?php foreach ($gamesByConsole as $consoleName => $rows): ?>
                <div class="page-header" style="margin-top:22px;">
                  <h2 class="page-title" style="font-size:1.2rem;"><?= htmlspecialchars($consoleName) ?></h2>
                  <p class="page-subtitle">Jeux</p>
                </div>

                <div class="products-grid">
                  <?php foreach ($rows as $row): ?>
                    <?php
                      $gi = (int)$row["idx"];
                      $game = (array)$row["game"];

                      $name = (string)($game["name"] ?? "Jeu");
                      $img = (string)($game["image"] ?? "");
                      $desc = (string)($game["description"] ?? "");
                      $stock = (int)($game["stock"] ?? 0);

                      [$ttc, $final, $hasDiscount] = priceParts((float)($game["price"] ?? 0), 20.0, 0.0);
                      $cat = getGameCategory($game);
                    ?>
                    <article class="product-card">
                      <div class="product-card__image-wrapper">
                        <img
                          src="<?= htmlspecialchars($img) ?>"
                          alt="<?= htmlspecialchars($name) ?>"
                          class="product-card__image"
                        />
                        <div class="product-card__badges">
                          <?php if ($stock <= 0): ?>
                            <span class="badge badge--out-of-stock">Rupture</span>
                          <?php elseif ($stock <= 3): ?>
                            <span class="badge badge--low-stock">Derniers</span>
                          <?php endif; ?>
                        </div>
                      </div>

                      <div class="product-card__content">
                        <span class="product-card__category"><?= htmlspecialchars($cat) ?></span>

                        <a href="#" class="product-card__title">
                          <?= htmlspecialchars($name) ?>
                        </a>

                        <div class="product-card__price">
                          <span class="product-card__price-current"><?= formatPrice($final) ?></span>
                        </div>

                        <?php if ($desc !== ""): ?>
                          <p style="margin:8px 0 10px;opacity:.85;">
                            <?= htmlspecialchars($desc) ?>
                          </p>
                        <?php endif; ?>

                        <p class="product-card__stock <?= htmlspecialchars(stockClass($stock)) ?>">
                          <?= htmlspecialchars(stockText($stock)) ?>
                        </p>

                        <div class="product-card__actions">
                          <form method="post" style="margin:0;">
                            <input type="hidden" name="type" value="game">
                            <input type="hidden" name="index" value="<?= (int)$gi ?>">
                            <button
                              type="submit"
                              name="add_to_cart"
                              class="btn btn--primary btn--block"
                              <?= $stock <= 0 ? "disabled" : "" ?>
                            >Ajouter</button>
                          </form>
                        </div>
                      </div>
                    </article>
                  <?php endforeach; ?>
                </div>
              <?php endforeach; ?>

            <?php endif; ?>

            <nav class="pagination" aria-label="Pagination" style="margin-top:18px;">
              <a class="pagination__item pagination__item--disabled">←</a>
              <a class="pagination__item pagination__item--active">1</a>
              <a class="pagination__item">2</a>
              <a class="pagination__item">3</a>
              <a class="pagination__item">→</a>
            </nav>
          </div>
        </div>
      </div>
    </main>

    <footer class="footer">
      <div class="container">
        <div class="footer__grid">
          <div class="footer__section">
            <h4>À propos</h4>
            <p>MaBoutique - Shopping en ligne.</p>
          </div>
          <div class="footer__section">
            <h4>Navigation</h4>
            <ul>
              <li><a href="index.php">Accueil</a></li>
              <li><a href="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>?view=<?= htmlspecialchars($view) ?>">Catalogue</a></li>
              <li><a href="contact.php">Contact</a></li>
            </ul>
          </div>
          <div class="footer__section">
            <h4>Compte</h4>
            <ul>
              <li><a href="connexion.php">Connexion</a></li>
              <li><a href="inscription.php">Inscription</a></li>
              <li><a href="panier.php">Panier</a></li>
            </ul>
          </div>
          <div class="footer__section">
            <h4>Formation</h4>
            <ul>
              <li><a href="#">Jour 1-5</a></li>
              <li><a href="#">Jour 6-10</a></li>
              <li><a href="#">Jour 11-14</a></li>
            </ul>
          </div>
        </div>
        <div class="footer__bottom"><p>&copy; 2024 MaBoutique</p></div>
      </div>
    </footer>
  </body>
</html>
