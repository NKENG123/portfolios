<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="ajouter.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
session_start();
include "conn.php";

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: connexion.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titre = htmlspecialchars(trim($_POST['titre']));
    $description = htmlspecialchars(trim($_POST['description']));
    $type = $_POST['type'];
    $date = date("Y-m-d");

    $fichier = $_FILES['fichier'];
    $targetFile = null;

    if ($fichier && $fichier['error'] == 0) {
        $targetDir = "oads/";
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $fileName = basename($fichier["name"]);
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        // Association des types avec extensions valides
        $typeMap = [
            'PDF' => ['pdf'],
            'doc' => ['doc', 'docx'],
            'gdoc' => ['gdoc'],
            'pptx' => ['pptx'],
            'xlsx' => ['xlsx'],
            'psd' => ['psd'],
            'text' => ['txt', 'text']
        ];


        $typeValide = false;
        if (isset($typeMap[$type])) {
            $extensions = $typeMap[$type];
            $typeValide = in_array($fileExtension, $extensions);
        }


        if (!$typeValide) {
            echo "<script>alert('Le type sélectionné ne correspond pas au fichier.'); window.location='Ajouter.php';</script>";
            exit;
        }

        // Déplacement du fichier
        $targetFile = $targetDir . time() . "_" . $fileName;
        if (move_uploaded_file($fichier["tmp_name"], $targetFile)) {
            // Enregistrement dans la base
            $stmt = $conn->prepare("INSERT INTO ajout_document (user_id, titre, description, type, date, fichier)
                                    VALUES (:user_id, :titre, :description, :type, :date, :fichier)");
            $stmt->execute([
                ':user_id' => $_SESSION['user_id'],
                ':titre' => $titre,
                ':description' => $description,
                ':type' => $type,
                ':date' => $date,
                ':fichier' => $targetFile
            ]);

            echo "<script>alert('Document ajouté avec succès.'); window.location='mes document.php';</script>";
        } else {
            echo "<script>alert('Erreur lors du téléchargement du fichier.'); window.location='Ajouter.php';</script>";
        }
    } else {
        echo "<script>alert('Aucun fichier sélectionné ou erreur lors de l’envoi.'); window.location='Ajouter.php';</script>";
    }
}
?>



<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un document</title>
</head>
<body>


<nav>
    <a href="accueil.php">Accueil</a>
   
    <a href="deconnexion.php">Se déconnecter</a>
</nav>
<div class="container">

<form action="" method="post" enctype="multipart/form-data">
    <center>
    <fieldset>
       
    <table>
    <tr>
        <td><label for="docName">Nom du document :</label></td>
        <td><input type="text" id="docName" name="titre" placeholder="Entrez le nom" required></td>
    </tr>
    <tr>
        <td><label for="type">Type de document :</label></td>
        <td>
            <select name="type" id="type" required>
                <option value="">--Choisir--</option>
                <option value="PDF">PDF</option>
                <option value="doc">Word</option>
                <option value="gdoc">gdoc</option>
                <option value="pptx">pptx</option>
                <option value="xlsx">xlsx</option>
                <option value="psd">psd</option>
                <option value="text">text</option>
            </select>
        </td>
    </tr>
    <tr>
        <td><label for="date">Date :</label></td>
        <td><input type="date" id="date" name="date" required></td>
    </tr>
    <tr>
        <td><label for="Description">Description :</label></td>
        <td><textarea name="description" id="Description" rows="2" required></textarea></td>
    </tr>
    <tr>
        <td><label for="docfile">Fichier :</label></td>
        <td><input type="file" name="fichier" id="docfile" accept=".pdf,.doc,.docx,.txt,.pptx,.xlsx,.psd" required></td>
       
    </tr>
        <button type="submit">Ajouter</button>
    </table>
    </fieldset>
    </center>
</form>
</div>
   
</body>
</html>