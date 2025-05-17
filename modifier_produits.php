<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: connexion.php");
    exit();
}

$pdo = new PDO('mysql:host=localhost;dbname=supermarche_db;charset=utf8', 'root', '');

// Vérifie que l'ID est passé en paramètre
if (!isset($_GET['id'])) {
    header("Location: produits.php");
    exit();
}

$id = $_GET['id'];

// Récupère les infos du produit
$stmt = $pdo->prepare("SELECT * FROM produits WHERE id = ?");
$stmt->execute([$id]);
$produit = $stmt->fetch();

if (!$produit) {
    echo "Produit introuvable.";
    exit();
}

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $prix = $_POST['prix'];
    $quantite = $_POST['quantite'];

    $stmt = $pdo->prepare("UPDATE produits SET nom = ?, prix = ?, quantite = ? WHERE id = ?");
    $stmt->execute([$nom, $prix, $quantite, $id]);

    header("Location: produits.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un produit</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h2 class="mb-4">Modifier le produit</h2>

        <form method="post" class="row g-3">
            <div class="col-md-4">
                <label class="form-label">Nom</label>
                <input type="text" name="nom" class="form-control" value="<?= htmlspecialchars($produit['nom']) ?>" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Prix</label>
                <input type="number" step="0.01" name="prix" class="form-control" value="<?= $produit['prix'] ?>" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Quantité</label>
                <input type="number" name="quantite" class="form-control" value="<?= $produit['quantite'] ?>" required>
            </div>
            <div class="col-md-2 align-self-end">
                <button type="submit" class="btn btn-primary w-100">Enregistrer</button>
            </div>
        </form>

        <div class="mt-4">
            <a href="produits.php" class="btn btn-secondary">Annuler</a>
        </div>
    </div>
</body>
</html>