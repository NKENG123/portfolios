<?php
session_start();
include "conn.php";

// Redirige vers la page de connexion si l'utilisateur n'est pas connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: connexion.php");
    exit;
}

// Récupération des informations de l'utilisateur connecté
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT * FROM inscription WHERE id = :id");
$stmt->execute([':id' => $user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mon profil</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f2f2f2;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #333;
            color: white;
            padding: 15px;
            text-align: center;
        }

        nav {
            background: #444;
            padding: 10px;
            text-align: center;
        }

        nav a {
            color: white;
            margin: 0 15px;
            text-decoration: none;
        }

        .container {
            max-width: 600px;
            background-color: white;
            padding: 25px;
            margin: 30px auto;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            margin-top: 0;
        }

        .info {
            margin-bottom: 15px;
        }

        .info label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        .info span {
            display: block;
        }
        .logo-text {
    font-size: 28px;
    font-weight: bold;
    color: white;
    background-color: #007BFF;
    padding: 8px 14px;
    border-radius: 2000px;
    font-family: Arial, sans-serif;
}
.nation a {
    color: white;
    text-decoration: none;
    padding: 10px 20px;
    border-radius: 5px;
    transition: background-color 0.3s ease;
}
.nation a:hover {
    background-color: #007BFF;
}
        .nation {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
        }
        .nation a {
            margin: 0 10px;
            text-decoration: none;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            background-color: #444;
        }

        footer {
            background: #333;
            color: white;
            text-align: center;
            padding: 15px;
            position: relative;
            bottom: 0;
            width: 100%;
            margin-top: 40px;
        }
    </style>
</head>
<body>

<header>
    <h1>Mon profil</h1>
    <nav class="nation">
    <div class="logo-text">FT</div>
</nav>
</header>

<nav>
    <a href="accueil.php">Accueil</a>
    <a href="mes document.php">Mes documents</a>
    <a href="Ajouter.php">Ajouter</a>
    <a href="profil.php">Mon profil</a>
    <a href="deconnexion.php">Se déconnecter</a>
</nav>

<div class="container">
    <h2>Informations personnelles</h2>

    <?php if ($user): ?>
        <div class="info">
            <label>Nom :</label>
            <span><?= htmlspecialchars($user['nom']) ?></span>
        </div>
        <div class="info">
            <label>Nom d'utilisateur :</label>
            <span><?= htmlspecialchars($user['prenom']) ?></span>
        </div>
        <div class="info">
            <label>Email :</label>
            <span><?= htmlspecialchars($user['email']) ?></span>
        </div>
        <div class="info">
            <label> telephone :</label>
            <span><?= htmlspecialchars($user['telephone']) ?></span>
        </div>
        </div>
<div style="text-align: center; margin-top: 30px;">
    <button onclick="history.back()" style="padding: 10px 20px; background-color: #555; color: white; border: none; border-radius: 5px; cursor: pointer;">
        ← Retour
    </button>
</div>
    <?php else: ?>
        <p>Impossible de récupérer vos informations.</p>
    <?php endif; ?>



<footer>
    © <?= date("Y") ?> gestion de documents. Tous droits réservés.
</footer>

</body>
</html>
