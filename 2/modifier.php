<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="modifier.css">
    <meta name="description" content="Page de modification de document.">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
session_start();
include "conn.php";

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: connexion.php");
    exit;
}

// Vérifier si un ID de document est passé
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "Document non spécifié.";
    exit;
}

$id = $_GET['id'];

// Récupération des infos actuelles du document
$stmt = $conn->prepare("SELECT * FROM ajout_document WHERE id = :id AND user_id = :user_id");
$stmt->execute([
    ':id' => $id,
    ':user_id' => $_SESSION['user_id']
]);

$document = $stmt->fetch();

if (!$document) {
    echo "Document introuvable ou accès non autorisé.";
    exit;
}

// Traitement du formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titre = htmlspecialchars($_POST['titre']);
    $description = htmlspecialchars($_POST['description']);
    $type = $_POST['type'];
    $date = $_POST['date'];
    $fichier = $_FILES['fichier'];
    $targetFile = $document['fichier']; // Valeur par défaut

    // Si un nouveau fichier est uploadé
    if ($fichier['error'] == 0) {
        $fileName = basename($fichier["name"]);
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        $typeMap = [
            'PDF' => 'pdf',
            'word' => ['doc', 'docx'],
            'gdoc' => 'gdoc',
            'pptx' => 'pptx',
            'xlsx' => 'xlsx',
            'psd' => 'psd',
            'text' => ['txt', 'text']
        ];

        $typeValide = false;
        if (isset($typeMap[$type])) {
            $extensions = (array)$typeMap[$type];
            $typeValide = in_array($fileExtension, $extensions);
        }

        if (!$typeValide) {
            echo "<script>alert('Le type sélectionné ne correspond pas au fichier.');</script>";
        } else {
            $targetDir = "uploads/";
            if (!file_exists($targetDir)) {
                mkdir($targetDir, 0777, true);
            }

            $targetFile = $targetDir . $fileName;
            move_uploaded_file($fichier["tmp_name"], $targetFile);
        }
    }

    // Mise à jour dans la base
    $update = $conn->prepare("UPDATE ajout_document SET titre = :titre, description = :description, type = :type, date = :date, fichier = :fichier WHERE id = :id AND user_id = :user_id");
    $update->execute([
        ':titre' => $titre,
        ':description' => $description,
        ':type' => $type,
        ':date' => $date,
        ':fichier' => $targetFile,
        ':id' => $id,
        ':user_id' => $_SESSION['user_id']
    ]);

    echo "<script>alert('Document modifié avec succès.'); window.location='mes document.php';</script>";
    exit;
}
?>


<header>
        <h1>Gestion de document</h1>
        <nav class="nation">
    <div class="logo-text">FT</div>
</nav>
</header>
<nav>
    <a href="accueil.php">Accueil</a>
    <a href="mes document.php">Mes documents</a>
    <a href="Ajouter.php">Ajouter</a>
    <a href="parametre.php">Paramètre</a>
    <a href="deconnexion.php">Se déconnecter</a>
</nav>
           
  

<form method="post" enctype="multipart/form-data">
    <h2>Modifier le document</h2>
    <p>Veuillez remplir les informations ci-dessous pour modifier le document.</p>

  
<center>
<fieldset>
    <legend>Informations du document</legend>
    <table>
        <tr>
            <td><label for="id">ID :</label></td>
            <td><input type="text" id="id" name="id" value="<?= $document['id'] ?>" readonly></td>
        </tr>
        <tr>
            <td><label for="fichier">Fichier actuel :</label></td>
            <td><a href="<?= $document['fichier'] ?>" target="_blank"><?= basename($document['fichier']) ?></a></td>
        </tr>
        <tr>
            <td><label for="fichier">Télécharger un nouveau fichier :</label></td>
            <td><input type="file" id="fichier" name="fichier"></td>
        </tr>
        <tr>
        <td><label for="docName">Nom du document :</label></td>
        <td>
            <select name="type" id="type"  value="<?= $document['type'] ?>" readonly>
                <option value="">--Choisir--</option>
                <option value="PDF">PDF</option>
                <option value="Word">Word</option>
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
            <td><input type="date" id="date" name="date" value="<?= $document['date'] ?>" required></td>
        </tr>
        <tr>
            <td><label for="description">Description :</label></td>
            <td><textarea id="description" name="description" rows="3" required><?= htmlspecialchars($document['description']) ?></textarea></td>
        </tr>
        <tr>
            <td><label for="titre">Titre :</label></td>
            <td><input type="text" id="titre" name="titre" value="<?= htmlspecialchars($document['titre']) ?>" required></td>
        </tr>
        <tr>
            <td colspan="2"><button type="submit">Mettre à jour</button></td>
        </tr>
    </table>
</fieldset>
</center>
</form>

    
    
  
    <footer>
        <p>&copy; 2025 gestion de documents. Tous droits réservés.</p>
    </footer>
</body>
</html>