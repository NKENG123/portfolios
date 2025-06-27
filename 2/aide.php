<?php
session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>

    <meta charset="UTF-8">
    <title>Aide - Gestion de documents</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        header {
            background-color: #333;
            color: white;
            padding: 15px;
            text-align: center;
        }

        main {
            padding: 20px;
            max-width: 800px;
            margin: auto;
            background-color: white;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
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

        h1 {
            color: #444;
        }

        h2 {
            color: #555;
            margin-top: 30px;
        }

        p {
            line-height: 1.6;
        }

        a.retour {
            display: inline-block;
            margin-top: 30px;
            text-decoration: none;
            background-color: #444;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
        }

        a.retour:hover {
            background-color: #666;
        }
    </style>
</head>
<body>

<header>
    <h1>Aide - Application de gestion de documents</h1>
    <nav class="nation">
    <div class="logo-text">FT</div>
</nav>
</header>

<main>
    <h2>1. Comment ajouter un document ?</h2>
    <p>Rendez-vous sur la page "Ajouter", remplissez le formulaire, sélectionnez le type et le fichier correspondant, puis cliquez sur "Ajouter".</p>

    <h2>2. Modifier ou supprimer un document ?</h2>
    <p>Allez sur la page "Mes documents", vous verrez une liste avec des boutons pour modifier ou supprimer chaque document.</p>

    <h2>3. Je n'arrive pas à me connecter</h2>
    <p>Assurez-vous d'utiliser l'adresse e-mail et le mot de passe corrects. Si vous n'avez pas de compte, inscrivez-vous depuis la page d'inscription.</p>

    <h2>4. Besoin d'aide supplémentaire ?</h2>
    <p>Contactez notre support à l'adresse : <a href="mailto:support@votreapp.com">support@votreapp.com</a></p>

    <a class="retour" href="accueil.php">← Retour à l'accueil</a>
</main>
<div style="margin-top: 20px;">
    <button onclick="history.back()" style="padding: 10px 20px; background-color: #555; color: white; border: none; border-radius: 5px; cursor: pointer;">
        ← Retour
    </button>
</div>


</body>
</html>
