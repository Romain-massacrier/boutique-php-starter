<?php
session_start();
require_once "../app/helpers.php"; // Vos fonctions d'aide

// TENTATIVE DE CONNEXION BDD (Chemin absolu pour éviter les erreurs)
$dbPath = '../config/database.php';

if (!file_exists($dbPath)) {
    die("ERREUR CRITIQUE : Le fichier $dbPath n'existe pas ! Vérifiez l'arborescence.");
}
require_once $dbPath;

$tva = 20.0;

// --- PANIER ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add'])) {
    $id = (int)$_POST['id'];
    $_SESSION['cart'][$id] = ($_SESSION['cart'][$id] ?? 0) + 1;
}

// --- RECUPERATION PRODUITS (SQL au lieu de data.php) ---
$sql = "SELECT * FROM products WHERE 1=1";
$params = [];

// Filtre Recherche
if (!empty($_GET['q'])) {
    $sql .= " AND name LIKE ?";
    $params[] = "%" . $_GET['q'] . "%";
}

// Filtre Catégorie (Version compatible avec votre BDD avancée)
// On fait une jointure car 'category' est une table séparée maintenant
if (!empty($_GET['category'])) {
    $sql = "SELECT p.* FROM products p 
            JOIN categories c ON p.category_id = c.id 
            WHERE c.slug = ?";
    // Si recherche aussi présente
    if (!empty($_GET['q'])) {
        $sql .= " AND p.name LIKE ?";
        $params = [$_GET['category'], "%" . $_GET['q'] . "%"];
    } else {
        $params = [$_GET['category']];
    }
}

try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $filteredProducts = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("ERREUR SQL : " . $e->getMessage());
}
?>

<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Boutique | E-commerce</title>

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

  <style>
    :root{
      --brand:#ffcc00; /* jaune */
      --brand-dark:#0b0f1a; /* fond sombre */
      --muted:#6c757d;
    }
    body{ background:#f6f7f9; }
    .topbar{ background: var(--brand-dark); }
    .brand-badge{
      background: var(--brand);
      color:#000;
      font-weight:800;
      letter-spacing:.5px;
      padding:.35rem .6rem;
      border-radius:.5rem;
      display:inline-flex;
      align-items:center;
      gap:.4rem;
      text-transform:uppercase;
    }
    .search-pill .form-control{ border:0; }
    .search-pill{ background:#fff; border-radius:999px; overflow:hidden; }
    .search-pill .btn{ border-radius:0; }
    .category-strip{
      background:#fff;
      border-bottom:1px solid rgba(0,0,0,.06);
    }
    .promo-card{
      border:0;
      border-radius:1rem;
      overflow:hidden;
    }
    .product-card{
      border:0;
      border-radius:1rem;
      overflow:hidden;
      box-shadow: 0 6px 18px rgba(0,0,0,.06);
      transition: transform .12s ease;
    }
    .product-card:hover{ transform: translateY(-2px); }
    .price{ font-weight:800; font-size:1.15rem; }
    .old-price{ color:var(--muted); text-decoration: line-through; font-size:.9rem; }
    .rating i{ color:#f3b400; }
    .chip{
      display:inline-flex;
      align-items:center;
      gap:.35rem;
      padding:.25rem .55rem;
      border-radius:999px;
      background:rgba(0,0,0,.05);
      font-size:.85rem;
    }
    footer{ background:#0b0f1a; color:#cbd5e1; }
    footer a{ color:#cbd5e1; text-decoration:none; }
    footer a:hover{ text-decoration:underline; }
  </style>
</head>

<body>

  <!-- TOPBAR -->
  <div class="topbar text-white">
    <div class="container py-2 d-flex align-items-center justify-content-between flex-wrap gap-2">
      <div class="d-flex align-items-center gap-2">
        <span class="brand-badge"><i class="bi bi-bag"></i> Boutique</span>
        <small class="text-white-50">Livraison offerte dès 49€</small>
      </div>

      <div class="d-flex align-items-center gap-3">
        <a class="text-white text-decoration-none" href="#"><i class="bi bi-person"></i> Compte</a>
        <a class="text-white text-decoration-none" href="#"><i class="bi bi-heart"></i> Favoris</a>
        <a class="text-white text-decoration-none" href="#"><i class="bi bi-cart3"></i> Panier <span class="badge text-bg-warning ms-1">2</span></a>
      </div>
    </div>
  </div>

  <!-- HEADER SEARCH -->
  <header class="py-3">
    <div class="container">
      <div class="row g-2 align-items-center">
        <div class="col-12 col-lg-3">
          <a class="text-decoration-none" href="#">
            <div class="d-flex align-items-center gap-2">
              <div class="brand-badge"><i class="bi bi-lightning-charge"></i> MegaShop</div>
              <div class="d-none d-sm-block">
                <div class="fw-bold text-dark">MegaShop</div>
                <div class="text-muted small">Tech, culture, gaming</div>
              </div>
            </div>
          </a>
        </div>

        <div class="col-12 col-lg-6">
          <form class="search-pill d-flex">
            <input class="form-control px-4 py-2" type="search" placeholder="Rechercher un produit, une marque..." aria-label="Search">
            <button class="btn btn-dark px-4" type="submit"><i class="bi bi-search"></i></button>
          </form>
          <div class="mt-2 d-flex flex-wrap gap-2">
            <span class="chip"><i class="bi bi-fire"></i> Top ventes</span>
            <span class="chip"><i class="bi bi-percent"></i> Promos</span>
            <span class="chip"><i class="bi bi-controller"></i> Gaming</span>
            <span class="chip"><i class="bi bi-headphones"></i> Audio</span>
          </div>
        </div>

        <div class="col-12 col-lg-3 text-lg-end">
          <button class="btn btn-outline-dark me-2" type="button">
            <i class="bi bi-geo-alt"></i> Magasins
          </button>
          <button class="btn btn-warning fw-bold" type="button">
            <i class="bi bi-shield-check"></i> Garantie
          </button>
        </div>
      </div>
    </div>
  </header>

  <!-- CATEGORY STRIP -->
  <nav class="category-strip">
    <div class="container py-2">
      <div class="d-flex flex-wrap gap-2 align-items-center">
        <button class="btn btn-dark btn-sm" type="button">
          <i class="bi bi-list"></i> Toutes les catégories
        </button>
        <a class="btn btn-light btn-sm" href="#">High-Tech</a>
        <a class="btn btn-light btn-sm" href="#">TV & Vidéo</a>
        <a class="btn btn-light btn-sm" href="#">Informatique</a>
        <a class="btn btn-light btn-sm" href="#">Téléphonie</a>
        <a class="btn btn-light btn-sm" href="#">Jeux vidéo</a>
        <a class="btn btn-light btn-sm" href="#">Livres</a>
        <a class="btn btn-light btn-sm" href="#">Musique</a>
      </div>
    </div>
  </nav>

  <main class="py-4">
    <div class="container">
      <div class="row g-4">

        <!-- LEFT FILTERS -->
        <aside class="col-12 col-lg-3">
          <div class="card border-0 rounded-4 p-3">
            <div class="d-flex align-items-center justify-content-between">
              <h5 class="mb-0">Filtres</h5>
              <button class="btn btn-link text-decoration-none p-0">Réinitialiser</button>
            </div>
            <hr>

            <div class="mb-3">
              <label class="form-label fw-semibold">Catégorie</label>
              <select class="form-select">
                <option>Tout</option>
                <option>Informatique</option>
                <option>TV & Vidéo</option>
                <option>Téléphonie</option>
                <option>Jeux vidéo</option>
              </select>
            </div>

            <div class="mb-3">
              <label class="form-label fw-semibold">Prix</label>
              <div class="input-group">
                <span class="input-group-text">€</span>
                <input type="number" class="form-control" placeholder="Min">
                <input type="number" class="form-control" placeholder="Max">
              </div>
            </div>

            <div class="mb-3">
              <label class="form-label fw-semibold">Marques</label>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="b1">
                <label class="form-check-label" for="b1">Sony</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="b2">
                <label class="form-check-label" for="b2">Samsung</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="b3">
                <label class="form-check-label" for="b3">Apple</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="b4">
                <label class="form-check-label" for="b4">Asus</label>
              </div>
            </div>

            <div class="mb-3">
              <label class="form-label fw-semibold">Note</label>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="r1">
                <label class="form-check-label" for="r1">4 étoiles et +</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="r2">
                <label class="form-check-label" for="r2">3 étoiles et +</label>
              </div>
            </div>

            <button class="btn btn-dark w-100">Appliquer</button>
          </div>
        </aside>

        <!-- RIGHT CONTENT -->
        <section class="col-12 col-lg-9">

          <!-- PROMO CAROUSEL -->
          <div id="promoCarousel" class="carousel slide mb-4" data-bs-ride="carousel">
            <div class="carousel-inner rounded-4">
              <div class="carousel-item active">
                <div class="p-4 p-md-5 bg-white promo-card">
                  <div class="row align-items-center g-3">
                    <div class="col-md-7">
                      <span class="badge text-bg-warning">Offre flash</span>
                      <h2 class="mt-2 mb-2 fw-bold">Jusqu’à -30% sur le high-tech</h2>
                      <p class="text-muted mb-3">TV, casques, PC portables, accessoires. Stocks limités.</p>
                      <button class="btn btn-dark btn-lg"><i class="bi bi-bag"></i> Voir les offres</button>
                    </div>
                    <div class="col-md-5 text-center">
                      <div class="ratio ratio-4x3 rounded-4 bg-light">
                        <div class="d-flex align-items-center justify-content-center text-muted">
                          Image promo (placeholder)
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="carousel-item">
                <div class="p-4 p-md-5 bg-white promo-card">
                  <div class="row align-items-center g-3">
                    <div class="col-md-7">
                      <span class="badge text-bg-dark">Nouveautés</span>
                      <h2 class="mt-2 mb-2 fw-bold">Gaming, consoles et accessoires</h2>
                      <p class="text-muted mb-3">Bundles, manettes, casques, cartes cadeaux.</p>
                      <button class="btn btn-warning btn-lg fw-bold"><i class="bi bi-controller"></i> Découvrir</button>
                    </div>
                    <div class="col-md-5 text-center">
                      <div class="ratio ratio-4x3 rounded-4 bg-light">
                        <div class="d-flex align-items-center justify-content-center text-muted">
                          Image gaming (placeholder)
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#promoCarousel" data-bs-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Précédent</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#promoCarousel" data-bs-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Suivant</span>
            </button>
          </div>

          <!-- TOOLBAR -->
          <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
            <div class="text-muted">Résultats: <strong>24</strong></div>
            <div class="d-flex align-items-center gap-2">
              <select class="form-select" style="max-width: 220px;">
                <option>Trier: Pertinence</option>
                <option>Prix croissant</option>
                <option>Prix décroissant</option>
                <option>Meilleures notes</option>
                <option>Nouveautés</option>
              </select>
              <button class="btn btn-outline-dark" type="button"><i class="bi bi-grid"></i></button>
              <button class="btn btn-outline-dark" type="button"><i class="bi bi-list-task"></i></button>
            </div>
          </div>

          <!-- PRODUCT GRID -->
          <div class="row g-3">
            <!-- Product 1 -->
            <div class="col-12 col-md-6 col-xl-4">
              <div class="card product-card h-100">
                <div class="ratio ratio-4x3 bg-light">
                  <div class="d-flex align-items-center justify-content-center text-muted">Image produit</div>
                </div>
                <div class="card-body">
                  <div class="d-flex justify-content-between align-items-start gap-2">
                    <h6 class="card-title mb-1">Casque Bluetooth XYZ</h6>
                    <button class="btn btn-sm btn-outline-dark"><i class="bi bi-heart"></i></button>
                  </div>
                  <div class="rating small mb-2" aria-label="Note 4 sur 5">
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star"></i>
                    <span class="text-muted ms-1">(128)</span>
                  </div>

                  <div class="d-flex align-items-baseline gap-2 mb-2">
                    <span class="price">99,99€</span>
                    <span class="old-price">129,99€</span>
                    <span class="badge text-bg-warning">-23%</span>
                  </div>

                  <div class="d-flex flex-wrap gap-2 mb-3">
                    <span class="badge text-bg-light text-dark border">Livraison 48h</span>
                    <span class="badge text-bg-light text-dark border">Retrait magasin</span>
                  </div>

                  <button class="btn btn-dark w-100">
                    <i class="bi bi-cart-plus"></i> Ajouter au panier
                  </button>
                </div>
              </div>
            </div>

            <!-- Product 2 -->
            <div class="col-12 col-md-6 col-xl-4">
              <div class="card product-card h-100">
                <div class="ratio ratio-4x3 bg-light">
                  <div class="d-flex align-items-center justify-content-center text-muted">Image produit</div>
                </div>
                <div class="card-body">
                  <div class="d-flex justify-content-between align-items-start gap-2">
                    <h6 class="card-title mb-1">Smartphone ABC 256Go</h6>
                    <button class="btn btn-sm btn-outline-dark"><i class="bi bi-heart"></i></button>
                  </div>
                  <div class="rating small mb-2">
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-half"></i>
                    <span class="text-muted ms-1">(542)</span>
                  </div>

                  <div class="d-flex align-items-baseline gap-2 mb-2">
                    <span class="price">799,00€</span>
                    <span class="old-price">899,00€</span>
                    <span class="badge text-bg-warning">-11%</span>
                  </div>

                  <div class="d-flex flex-wrap gap-2 mb-3">
                    <span class="badge text-bg-light text-dark border">Paiement 4x</span>
                    <span class="badge text-bg-light text-dark border">Garantie 2 ans</span>
                  </div>

                  <button class="btn btn-dark w-100">
                    <i class="bi bi-cart-plus"></i> Ajouter au panier
                  </button>
                </div>
              </div>
            </div>

            <!-- Product 3 -->
            <div class="col-12 col-md-6 col-xl-4">
              <div class="card product-card h-100">
                <div class="ratio ratio-4x3 bg-light">
                  <div class="d-flex align-items-center justify-content-center text-muted">Image produit</div>
                </div>
                <div class="card-body">
                  <div class="d-flex justify-content-between align-items-start gap-2">
                    <h6 class="card-title mb-1">PC portable 15" Pro</h6>
                    <button class="btn btn-sm btn-outline-dark"><i class="bi bi-heart"></i></button>
                  </div>
                  <div class="rating small mb-2">
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star"></i>
                    <i class="bi bi-star"></i>
                    <span class="text-muted ms-1">(89)</span>
                  </div>

                  <div class="d-flex align-items-baseline gap-2 mb-2">
                    <span class="price">1 199,00€</span>
                    <span class="old-price">1 399,00€</span>
                    <span class="badge text-bg-warning">-14%</span>
                  </div>

                  <div class="d-flex flex-wrap gap-2 mb-3">
                    <span class="badge text-bg-light text-dark border">SSD 1To</span>
                    <span class="badge text-bg-light text-dark border">16Go RAM</span>
                  </div>

                  <button class="btn btn-dark w-100">
                    <i class="bi bi-cart-plus"></i> Ajouter au panier
                  </button>
                </div>
              </div>
            </div>
          </div>

          <!-- PAGINATION -->
          <nav class="mt-4">
            <ul class="pagination justify-content-center">
              <li class="page-item disabled"><a class="page-link" href="#">Précédent</a></li>
              <li class="page-item active"><a class="page-link" href="#">1</a></li>
              <li class="page-item"><a class="page-link" href="#">2</a></li>
              <li class="page-item"><a class="page-link" href="#">3</a></li>
              <li class="page-item"><a class="page-link" href="#">Suivant</a></li>
            </ul>
          </nav>

        </section>
      </div>
    </div>
  </main>

  <!-- FOOTER -->
  <footer class="pt-5 pb-4">
    <div class="container">
      <div class="row g-4">
        <div class="col-12 col-md-4">
          <div class="brand-badge mb-2"><i class="bi bi-bag"></i> MegaShop</div>
          <p class="mb-0">E-commerce démo avec Bootstrap. Ajoute tes données, ton backend et tes images.</p>
        </div>
        <div class="col-6 col-md-2">
          <h6 class="text-white">Aide</h6>
          <ul class="list-unstyled small">
            <li><a href="#">Livraison</a></li>
            <li><a href="#">Retours</a></li>
            <li><a href="#">Paiement</a></li>
            <li><a href="#">SAV</a></li>
          </ul>
        </div>
        <div class="col-6 col-md-2">
          <h6 class="text-white">Boutique</h6>
          <ul class="list-unstyled small">
            <li><a href="#">Promotions</a></li>
            <li><a href="#">Nouveautés</a></li>
            <li><a href="#">Meilleures ventes</a></li>
            <li><a href="#">Marques</a></li>
          </ul>
        </div>
        <div class="col-12 col-md-4">
          <h6 class="text-white">Newsletter</h6>
          <div class="input-group">
            <input class="form-control" type="email" placeholder="Ton email">
            <button class="btn btn-warning fw-bold" type="button">S’inscrire</button>
          </div>
          <div class="mt-3 d-flex gap-2">
            <a class="btn btn-outline-light btn-sm" href="#"><i class="bi bi-instagram"></i></a>
            <a class="btn btn-outline-light btn-sm" href="#"><i class="bi bi-youtube"></i></a>
            <a class="btn btn-outline-light btn-sm" href="#"><i class="bi bi-twitter-x"></i></a>
          </div>
        </div>
      </div>

      <hr class="border-secondary my-4">
      <div class="d-flex flex-wrap justify-content-between gap-2 small">
        <div>© 2026 MegaShop</div>
        <div class="d-flex gap-3">
          <a href="#">Mentions légales</a>
          <a href="#">CGV</a>
          <a href="#">Confidentialité</a>
        </div>
      </div>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
