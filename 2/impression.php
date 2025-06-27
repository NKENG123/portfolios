<?php
session_start();
include "conn.php";

// Assure-toi que l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Récupérer les documents de l'utilisateur
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT titre, fichier FROM ajout_document WHERE user_id = ?");
$stmt->execute([$user_id]);
$documents = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Impression des documents</title>
    <style>
        @media print {
            .no-print {
                display: none;
            }
            body {
                margin: 2cm;
                font-family: Arial, sans-serif;
            }
        }

        .document {
            margin-bottom: 30px;
            page-break-after: always;
        }
    </style>
</head>
<body>

<div class="no-print">
    <button onclick="window.print()">Imprimer</button>
</div>

<h1>Mes Documents</h1>

<?php foreach ($documents as $doc): ?>
    <div class="document">
        <h2><?= htmlspecialchars($doc['titre']) ?></h2>
        <td><a class="btn" href="<?= htmlspecialchars($doc['fichier']) ?>" target="_blank">Voir</a></td>
        <p><?= (htmlspecialchars($doc['fichier'])) ?> <target="_blank"/p>
    </div>
<?php endforeach; ?>

</body>
</html>
