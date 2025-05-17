<?php
session_start();

// Redirige vers la page de connexion si l'utilisateur n'est pas connecté
if (!isset($_SESSION['username'])) {
    header("Location: connexion.php");
    exit();
}

$username = $_SESSION['username'];
$role = $_SESSION['role'];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil - Supermarché</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <span class="navbar-brand">Supermarché</span>
            <div class="d-flex">
                <a href="deconnexion.php" class="btn btn-outline-light btn-sm">Déconnexion</a>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="text-center">
            <h2>Bienvenue, <?= htmlspecialchars($username) ?> !</h2>
            <p class="text-muted">Vous êtes connecté en tant que <strong><?= htmlspecialchars($role) ?></strong>.</p>
            <hr>
            <p>Utilisez le menu pour gérer les produits, les stocks ou les utilisateurs.</p>
        </div>
    </div>
</body>
</html>