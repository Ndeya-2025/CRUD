<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: connexion.php");
    exit();
}

$pdo = new PDO('mysql:host=localhost;dbname=supermarche_db;charset=utf8', 'root', '');

$search = '';
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search = $_GET['search'];
    $stmt = $pdo->prepare("SELECT * FROM produits WHERE nom LIKE ?");
    $stmt->execute(['%' . $search . '%']);
    $produits = $stmt->fetchAll();
} else {
    $stmt = $pdo->query("SELECT * FROM produits");
    $produits = $stmt->fetchAll();
}
// Suppression
if (isset($_GET['supprimer'])) {
    $id = $_GET['supprimer'];
    $pdo->prepare("DELETE FROM produits WHERE id = ?")->execute([$id]);
    header("Location: produits.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Produits</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h2 class="mb-4">Gestion des produits</h2>

        <!-- Formulaire d'ajout -->
        <form method="post" class="row g-3 mb-4">
            <div class="col-md-4">
                <input type="text" name="nom" class="form-control" placeholder="Nom du produit" required>
            </div>
            <div class="col-md-3">
                <input type="number" step="0.01" name="prix" class="form-control" placeholder="Prix" required>
            </div>
            <div class="col-md-3">
                <input type="number" name="quantite" class="form-control" placeholder="Quantité" required>
            </div>
            <div class="col-md-2">
                <button type="submit" name="ajouter" class="btn btn-success w-100">Ajouter</button>
            </div>
        </form>
        <form method="get" class="mb-3 row">
            <div class="col-md-10">
                <input type="text" name="search" class="form-control" placeholder="Rechercher un produit..." value="<?= htmlspecialchars($search) ?>">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Rechercher</button>
            </div>
</form>
        <!-- Tableau des produits -->
        <table class="table table-bordered table-hover bg-white">
            <thead class="table-primary">
                <tr>
                    <th>Nom</th>
                    <th>Prix</th>
                    <th>Quantité</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($produits as $produit): ?>
                    <tr>
                        <td><?= htmlspecialchars($produit['nom']) ?></td>
                        <td><?= number_format($produit['prix'], 2, ',', ' ') ?> €</td>
                        <td><?= $produit['quantite'] ?></td>
                        <td>
                            <a href="modifier_produits.php?id=<?= $produit['id'] ?>" class="btn btn-warning btn-sm">Modifier</a>
                            <a href="produits.php?supprimer=<?= $produit['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer ce produit ?');">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <a href="accueil.php" class="btn btn-secondary">Retour à l'accueil</a>
    </div>
</body>
</html>