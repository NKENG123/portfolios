<?php
session_start();
include "conn.php";

// Vérifier l'accès
if (!isset($_SESSION['user_id'])) {
    header("Location: connexion.php");
    exit;
}

// Total des documents
$total_docs = $conn->query("SELECT COUNT(*) FROM ajout_document")->fetchColumn();

// Total des utilisateurs
$total_users = $conn->query("SELECT COUNT(*) FROM inscription")->fetchColumn();

// Documents par type
$types_stmt = $conn->query("SELECT type, COUNT(*) as total FROM ajout_document GROUP BY type");
$types = $types_stmt->fetchAll(PDO::FETCH_ASSOC);

// Documents par mois
$mois_stmt = $conn->query("SELECT DATE_FORMAT(date, '%Y-%m') as mois, COUNT(*) as total FROM ajout_document GROUP BY mois ORDER BY mois DESC LIMIT 6");
$mois_stats = $mois_stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Statistiques</title>
    <style>
        body { font-family: Arial; padding: 20px; background-color: #f4f4f4; }
        .card { background: white; border-radius: 8px; padding: 20px; margin-bottom: 20px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        h2 { margin-top: 0; }
        table { width: 100%; border-collapse: collapse; }
        td, th { border: 1px solid #ccc; padding: 8px; }
    </style>
</head>
<body>

<h1>📊 Statistiques générales</h1>

<div class="card">
    <h2>Résumé</h2>
    <p>Total des documents : <strong><?= $total_docs ?></strong></p>
    <p>Total des utilisateurs : <strong><?= $total_users ?></strong></p>
</div>

<div class="card">
    <h2>Documents par type</h2>
    <table>
        <tr><th>Type</th><th>Nombre</th></tr>
        <?php foreach ($types as $row): ?>
            <tr>
                <td><?= htmlspecialchars($row['type']) ?></td>
                <td><?= $row['total'] ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>

<div class="card">
    <h2>Documents ajoutés par mois</h2>
    <table>
        <tr><th>Mois</th><th>Nombre</th></tr>
        <?php foreach ($mois_stats as $row): ?>
            <tr>
                <td><?= $row['mois'] ?></td>
                <td><?= $row['total'] ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>

</body>
</html>
