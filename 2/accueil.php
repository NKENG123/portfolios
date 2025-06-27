<?php
session_start();
include "conn.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: connexion.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="accueil.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - Gestion de documents</title>
    <style>
        
    </style>
</head>
<body>

<header>
    <h1>Bienvenue </h1>
    <nav class="nation">
    
        <div class="search-bar">
            <input type="text" id="recherche" placeholder="Rechercher par titre...">
            <button type="button">🔍</button>
        </div>
    </nav>
</header>

<nav class="dimi">
    <a href="accueil.php">Accueil</a>
    <a href="mes document.php">Mes documents</a>
    <a href="Ajouter.php">Ajouter</a>
    <a href="parametre.php">Paramètre</a>
    <a href="deconnexion.php">Se déconnecter</a>
</nav>

<div class="container">
    <h2>📌 Documents les plus récents</h2>

    <table>
        <thead>
            <tr>
                <th>Titre</th>
                <th>Type</th>
                <th>Date</th>
                <th>Télécharger</th>
            </tr>
        </thead>
        <tbody id="resultats">
        </tbody>
    </table>
</div>



<script>
    const input = document.getElementById("recherche");
    const resultats = document.getElementById("resultats");

    function rechercher(q = "") {
        const xhr = new XMLHttpRequest();
        
        xhr.open("GET", "recherche.php?q=" + encodeURIComponent(q), true);
        xhr.onload = function () {
            if (xhr.status === 200) {
                resultats.innerHTML = xhr.responseText;
            }
        };
        xhr.send();
    }

    input.addEventListener("keyup", function () {
        const query = input.value.trim();
        rechercher(query);
    });

    window.addEventListener("DOMContentLoaded", () => {
        rechercher(); // afficher tous les documents au chargement
    });
</script>

</body>
</html>
