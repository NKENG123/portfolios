<?php
// Vérifie si le paramètre 'nouveau' et 'token' existent dans l'URL
$nouveau = isset($_GET['nouveau']) ? $_GET['nouveau'] : null;
$token = isset($_GET['token']) ? $_GET['token'] : null;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Réinitialiser le mot de passe</title>
    <style>
        body {
            background-color: #f2f2f2;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background-color: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            width: 90%;
            max-width: 400px;
            text-align: center;
        }

        h2 {
            margin-bottom: 20px;
            color: #333;
        }

        input[type="password"] {
            width: 100%;
            padding: 12px;
            margin: 12px 0;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-sizing: border-box;
        }

        button {
            background-color: #1d72b8;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #155d8b;
        }

        .message {
            margin-top: 15px;
            color: red;
        }

        a {
            display: block;
            margin-top: 20px;
            color: #1d72b8;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>🔐 Réinitialiser votre mot de passe</h2>
    
    <?php
    // Vérification de la présence des paramètres 'nouveau' et 'token'
    if ($nouveau === null || $token === null) {
        echo "<div class='message'>Erreur : Paramètres manquants dans l'URL. Veuillez vérifier votre lien.</div>";
    } else {
        // Logique de traitement de la réinitialisation du mot de passe
        echo "
        <form method='POST' action='traitement_reinitialisation.php'>
            <input type='password' name='nouveau_mot_de_passe' placeholder='Nouveau mot de passe' required>
            <input type='password' name='confirmer_mot_de_passe' placeholder='Confirmer le mot de passe' required>
            <input type='hidden' name='token' value='$token'>
            <button type='submit'>Réinitialiser le mot de passe</button>
        </form>";

        // Ajouter des messages pour guider l'utilisateur
        echo "<p>Entrez un nouveau mot de passe ci-dessus et cliquez sur le bouton pour le réinitialiser.</p>";
    }
    ?>

    <a href="connexion.php">← Retour à la connexion</a>
</div>

</body>
</html>
