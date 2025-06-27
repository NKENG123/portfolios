<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="parametre.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<?php
session_start();
include "conn.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: connexion.php");
    exit;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Vérifie si le document appartient à l'utilisateur
    $stmt = $conn->prepare("SELECT * FROM ajout_document WHERE id = :id AND user_id = :user_id");
    $stmt->execute([':id' => $id, ':user_id' => $_SESSION['user_id']]);
    $doc = $stmt->fetch();

    if ($doc) {
        // Supprimer le fichier physiquement
        if (file_exists($doc['fichier'])) {
            unlink($doc['fichier']);
        }

        // Supprimer de la base
        $delete = $conn->prepare("DELETE FROM ajout_document WHERE id = :id AND user_id = :user_id");
        $delete->execute([':id' => $id, ':user_id' => $_SESSION['user_id']]);
    }
}

header("Location: mes document.php");
exit;
?>

<body>
    <header>
        <nav>
        <h1>gestion de document</h1>
        <ul>
        <li><a href="accueil.php">Accueil</a></li>
            <li><a href="mes document.php"> Mes documents</a></li>
            <li><a href="Ajouter.php">Ajouter</a></li>
            <li><a href="parametres.php">Parametre</a></li>
            <li><a href="deconnexion.php">Se déconnecter</a></li>
            <li><a href="profil.php">Mon profil</a></li>
            <li><a href="aide.php">Aide</a></li>
        </ul>
    </nav>
    </header>
    
  
    <footer>
        <p>&copy; 2025 gestion de documents. Tous droits réservés.</p>
    </footer>
</body>
</html>