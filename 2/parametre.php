<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="parametre.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
 <header>
        <h1>Gestion de document</h1>
    </header>
<nav>
    <a href="accueil.php">Accueil</a>
   
    <a href="profil.php">Mon profil</a>
    <a href="aide.php">Aide</a>
    
    <a href="deconnexion.php">Se déconnecter</a>
    
</nav>
<?php
session_start();
include "conn.php";

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: connexion.php");
    exit;
}

// Récupère les infos utilisateur
$stmt = $conn->prepare("SELECT * FROM inscription WHERE id = :id");
$stmt->execute([':id' => $_SESSION['user_id']]);
$user = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Paramètres</title>
    
</head>
<body>

<header>
    <h1>Paramètres du compte</h1>

</header>

<main>
    <h2>Modifier mes informations</h2>
    <form action="modifier_profil.php" method="post">
        <label>Nom</label>
        <input type="text" name="nom" value="<?= htmlspecialchars($user['nom']) ?>" required>

        <label>Prénom</label>
        <input type="text" name="prenom" value="<?= htmlspecialchars($user['prenom']) ?>" required>

        <label>Email</label>
        <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>

        <label>Téléphone</label>
        <input type="text" name="telephone" value="<?= htmlspecialchars($user['telephone']) ?>" required>

        <button type="submit">Enregistrer les modifications</button>
    </form>

    <h2>Changer mon mot de passe</h2>
    <form action="changer_motdepasse.php" method="post">
        <label>Mot de passe actuel</label>
        <input type="password" name="actuel"placeholder=" Mot de passe actuel"  required>

        <label>Nouveau mot de passe</label>
        <input type="password" name="nouveau" placeholder="nouveau mot de passe" required>

        <label>Confirmer le nouveau mot de passe</label>
        <input type="password" name="confirmer" placeholder="confirmer mot de passe " required>

        <button type="submit">Changer le mot de passe</button>
    </form>

    <a class="retour" href="accueil.php">← Retour à l'accueil</a>
</main>

</body>
</html>


</body>
</html>