<?php
// starter-project/public/index.php

session_start();

require_once __DIR__ . "/../app/Entity/Product.php";
require_once __DIR__ . "/../app/data.php";     // $products (objets Product), $games (tableaux)
require_once __DIR__ . "/../app/helpers.php";  // formatPrice, calculateIncludingTax, calculateDiscount

use App\Entity\Product;

$cartCount = count($_SESSION["cart"] ?? []);

// Stats (consoles)
$totalProducts = 0;
$inStock = 0;
$onSale = 0;
$newCount = 0;

foreach ($products as $p) {
    if (!($p instanceof Product)) continue;
    $totalProducts++;

    if ($p->getStock() > 0) $inStock++;
    if ($p->getDiscount() > 0) $onSale++;
    if ($p->isNew()) $newCount++;
}

// Produits mis en avant (ici: les 4 premiers)
$featured = array_slice($products, 0, 4);

// Helpers d’affichage stock (mêmes idées que catalogue.php)
function stockClassHome(int $stock): string {
    if ($stock <= 0) return "product-card__stock--out";
    if ($stock <= 3) return "product-card__stock--low";
    return "product-card__stock--available";
}
function stockTextHome(int $stock): string {
    if ($stock <= 0) return "✗ Rupture";
    if ($stock <= 3) return "⚠ Plus que " . $stock;
    return "✓ En stock (" . $stock . ")";
}
function renderBadgesHome(Product $p): string {
    $out = [];

    if ($p->isNew()) {
        $out[] = '<span class="badge badge--new">Nouveau</span>';
    }
    if ($p->getDiscount() > 0) {
        $out[] = '<span class="badge badge--promo">-' . (int)$p->getDiscount() . '%</span>';
    }
    if ($p->getStock() > 0 && $p->getStock() <= 3) {
        $out[] = '<span class="badge badge--low-stock">Derniers</span>';
    }
    if ($p->getStock() <= 0) {
        $out[] = '<span class="badge badge--out-of-stock">Rupture</span>';
    }

    return implode("", $out);
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MaBoutique - Accueil</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>

<header class="header">
  <div class="container header__container">
    <a href="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>" class="header__logo">🛍️ MaBoutique</a>

    <nav class="header__nav">
      <a href="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>" class="header__nav-link header__nav-link--active">Accueil</a>
      <a href="catalogue.php" class="header__nav-link">Catalogue</a>
      <a href="contact.html" class="header__nav-link">Contact</a>
    </nav>

    <div class="header__actions">
      <a href="panier.html" class="header__cart">
        🛒<span class="header__cart-badge"><?= (int)$cartCount ?></span>
      </a>
      <a href="connexion.html" class="btn btn--primary btn--sm">Connexion</a>
    </div>

    <button class="header__menu-toggle">☰</button>
  </div>
</header>

<main class="main-content">
  <div class="container">

    <section class="hero">
      <div class="container hero__content">
        <h1 class="hero__title">Boutique Retro Gaming</h1>
        <p class="hero__subtitle">Consoles cultes et jeux légendaires. Stock limité, promos parfois très rares.</p>
        <div class="hero__actions">
          <a href="catalogue.php?view=consoles" class="btn btn--secondary btn--lg">Voir les consoles</a>
          <a href="catalogue.php?view=consoles&status=new" class="btn btn--outline btn--lg">Nouveautés</a>
        </div>
      </div>
    </section>

    <section class="stats-grid">
      <div class="stat-card">
        <div class="stat-card__icon stat-card__icon--primary">📦</div>
        <div class="stat-card__content">
          <div class="stat-card__value"><?= (int)$totalProducts ?></div>
          <div class="stat-card__label">Consoles</div>
        </div>
      </div>

      <div class="stat-card">
        <div class="stat-card__icon stat-card__icon--success">✅</div>
        <div class="stat-card__content">
          <div class="stat-card__value"><?= (int)$inStock ?></div>
          <div class="stat-card__label">En stock</div>
        </div>
      </div>

      <div class="stat-card">
        <div class="stat-card__icon stat-card__icon--warning">🏷️</div>
        <div class="stat-card__content">
          <div class="stat-card__value"><?= (int)$onSale ?></div>
          <div class="stat-card__label">En promo</div>
        </div>
      </div>

      <div class="stat-card">
        <div class="stat-card__icon stat-card__icon--secondary">🆕</div>
        <div class="stat-card__content">
          <div class="stat-card__value"><?= (int)$newCount ?></div>
          <div class="stat-card__label">Nouveautés</div>
        </div>
      </div>
    </section>

    <section id="produits">
      <div class="section-header">
        <h2 class="section-title">Consoles mises en avant</h2>
        <a href="catalogue.php?view=consoles" class="section-link">Voir tout →</a>
      </div>

      <div class="products-grid">
        <?php foreach ($featured as $i => $product): ?>
          <?php if (!($product instanceof Product)) continue; ?>

          <?php
            $name = $product->getName();
            $img = $product->getImage();
            $desc = $product->getDescription();
            $stock = $product->getStock();
            $discount = (float)$product->getDiscount();

            $ttc = calculateIncludingTax($product->getPrice(), 20.0);
            $hasDiscount = $discount > 0;
            $final = $hasDiscount ? calculateDiscount($ttc, $discount) : $ttc;
          ?>

          <article class="product-card">
            <div class="product-card__image-wrapper">
              <img
                src="<?= htmlspecialchars($img) ?>"
                alt="<?= htmlspecialchars($name) ?>"
                class="product-card__image"
              >
              <div class="product-card__badges">
                <?= renderBadgesHome($product) ?>
              </div>
            </div>

            <div class="product-card__content">
              <span class="product-card__category">Console</span>

              <a href="catalogue.php?view=consoles" class="product-card__title">
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

              <p class="product-card__stock <?= htmlspecialchars(stockClassHome((int)$stock)) ?>">
                <?= htmlspecialchars(stockTextHome((int)$stock)) ?>
              </p>

              <div class="product-card__actions">
                <form method="post" action="catalogue.php?view=consoles" style="margin:0;">
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
    </section>

  </div>
</main>

<footer class="footer">
  <div class="container">
    <div class="footer__grid">
      <div class="footer__section">
        <h4>À propos</h4>
        <p>MaBoutique retro gaming.</p>
      </div>
      <div class="footer__section">
        <h4>Navigation</h4>
        <ul>
          <li><a href="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>">Accueil</a></li>
          <li><a href="catalogue.php?view=consoles">Catalogue</a></li>
          <li><a href="contact.html">Contact</a></li>
        </ul>
      </div>
      <div class="footer__section">
        <h4>Compte</h4>
        <ul>
          <li><a href="connexion.html">Connexion</a></li>
          <li><a href="inscription.html">Inscription</a></li>
          <li><a href="panier.html">Panier</a></li>
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

    <div class="footer__bottom">
      <p>&copy; <?= (int)date("Y") ?> MaBoutique</p>
    </div>
  </div>
</footer>

</body>
</html>
