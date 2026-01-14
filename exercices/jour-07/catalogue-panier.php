<?php
declare(strict_types=1);
session_start();

/*
  Connexion BDD
  Adapte user/pass si besoin.
*/
try {
    $pdo = new PDO(
        "mysql:host=localhost;dbname=boutique;charset=utf8mb4",
        "dev",
        "dev",
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
    );
} catch (PDOException $e) {
    die("Erreur BDD : " . $e->getMessage());
}

function e(string $value): string {
    return htmlspecialchars($value, ENT_QUOTES, "UTF-8");
}

/*
  Panier en session : tableau associatif
  $_SESSION["cart"][product_id] = quantité
*/
if (!isset($_SESSION["cart"]) || !is_array($_SESSION["cart"])) {
    $_SESSION["cart"] = [];
}

/*
  Actions
  - add : ajoute 1 à un produit
  - reset : vide le panier
*/
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $action = $_POST["action"] ?? "";

    if ($action === "add") {
        $productId = filter_input(INPUT_POST, "product_id", FILTER_VALIDATE_INT);

        if ($productId !== false && $productId !== null && $productId > 0) {
            if (!isset($_SESSION["cart"][$productId])) {
                $_SESSION["cart"][$productId] = 0;
            }
            $_SESSION["cart"][$productId] += 1;
        }

        header("Location: catalogue-panier.php");
        exit;
    }

    if ($action === "reset") {
        $_SESSION["cart"] = [];
        header("Location: catalogue-panier.php");
        exit;
    }
}

/*
  Récupération produits
*/
$products = $pdo->query("SELECT * FROM products ORDER BY id DESC")->fetchAll();

/*
  Préparation affichage panier
  On récupère depuis la BDD uniquement les produits présents dans le panier
*/
$cartItems = [];
$cartTotal = 0.0;

$cartIds = array_keys($_SESSION["cart"]);
if (count($cartIds) > 0) {
    $placeholders = implode(",", array_fill(0, count($cartIds), "?"));
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id IN ($placeholders)");
    $stmt->execute($cartIds);
    $productsInCart = $stmt->fetchAll();

    // Index par id pour accès rapide
    $byId = [];
    foreach ($productsInCart as $p) {
        $byId[(int)$p["id"]] = $p;
    }

    foreach ($_SESSION["cart"] as $id => $qty) {
        $id = (int)$id;
        $qty = (int)$qty;

        if ($qty <= 0) {
            continue;
        }

        if (!isset($byId[$id])) {
            continue;
        }

        $p = $byId[$id];

        // Adapte le nom du champ prix si chez toi ce n'est pas "price"
        $price = isset($p["price"]) ? (float)$p["price"] : 0.0;

        $lineTotal = $price * $qty;
        $cartTotal += $lineTotal;

        $cartItems[] = [
            "id" => $id,
            "name" => (string)($p["name"] ?? ("Produit #" . $id)),
            "price" => $price,
            "qty" => $qty,
            "line_total" => $lineTotal,
        ];
    }
}

function formatPrice(float $value): string {
    return number_format($value, 2, ",", " ") . " €";
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Catalogue + Panier (Session)</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body { font-family: system-ui, Arial, sans-serif; margin: 24px; }
        .layout { display: grid; grid-template-columns: 2fr 1fr; gap: 24px; }
        .card { border: 1px solid #ddd; border-radius: 10px; padding: 16px; }
        .row { display: flex; justify-content: space-between; gap: 12px; align-items: center; }
        .muted { color: #666; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 10px; border-bottom: 1px solid #eee; text-align: left; }
        .btn { cursor: pointer; padding: 8px 12px; border-radius: 8px; border: 1px solid #333; background: #fff; }
        .btn-primary { background: #111; color: #fff; border-color: #111; }
        .btn-danger { border-color: #b00020; color: #b00020; }
        .btn-danger:hover { background: #b00020; color: #fff; }
        .btn-primary:hover { opacity: 0.9; }
        .small { font-size: 0.9rem; }
    </style>
</head>
<body>

<h1>Catalogue produits</h1>
<p class="muted small">Panier persistant via session PHP</p>

<div class="layout">
    <section class="card">
        <h2>Produits</h2>

        <?php if (count($products) === 0): ?>
            <p>Aucun produit en base.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th class="row">Prix</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($products as $p): ?>
                    <?php
                        $id = (int)$p["id"];
                        $name = (string)($p["name"] ?? ("Produit #" . $id));
                        $price = isset($p["price"]) ? (float)$p["price"] : 0.0;
                    ?>
                    <tr>
                        <td><?php echo $id; ?></td>
                        <td><?php echo e($name); ?></td>
                        <td><?php echo formatPrice($price); ?></td>
                        <td>
                            <form method="POST" style="margin:0;">
                                <input type="hidden" name="action" value="add">
                                <input type="hidden" name="product_id" value="<?php echo $id; ?>">
                                <button class="btn btn-primary" type="submit">Ajouter au panier</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </section>

    <aside class="card">
        <div class="row">
            <h2 style="margin:0;">Panier</h2>

            <form method="POST" style="margin:0;">
                <input type="hidden" name="action" value="reset">
                <button class="btn btn-danger" type="submit">Vider</button>
            </form>
        </div>

        <?php if (count($cartItems) === 0): ?>
            <p class="muted">Ton panier est vide.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Produit</th>
                        <th>Qté</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($cartItems as $item): ?>
                    <tr>
                        <td><?php echo e($item["name"]); ?></td>
                        <td><?php echo (int)$item["qty"]; ?></td>
                        <td><?php echo formatPrice((float)$item["line_total"]); ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="2">Total panier</th>
                        <th><?php echo formatPrice((float)$cartTotal); ?></th>
                    </tr>
                </tfoot>
            </table>
        <?php endif; ?>

        <p class="muted small" style="margin-top:12px;">
            Stockage session : <code>$_SESSION["cart"][product_id] = qty</code>
        </p>
    </aside>
</div>

</body>
</html>
