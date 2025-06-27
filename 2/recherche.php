<?php
session_start();
include "conn.php";

if (!isset($_SESSION['user_id'])) {
    exit;
}

$lettres = isset($_GET['q']) ? $_GET['q'] : '';

$stmt = $conn->prepare("SELECT * FROM ajout_document WHERE user_id = :user_id AND titre LIKE :titre ORDER BY date DESC");
$stmt->execute([
    ':user_id' => $_SESSION['user_id'],
    ':titre' => "%$lettres%"
]);

$documents = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (count($documents) > 0) {
    foreach ($documents as $doc) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($doc['titre']) . "</td>";
        echo "<td>" . htmlspecialchars($doc['type']) . "</td>";
        echo "<td>" . htmlspecialchars($doc['date']) . "</td>";
        echo "<td><a class='btn' href='" . htmlspecialchars($doc['fichier']) . "' download>Voir</a></td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='4'>Aucun document trouvé.</td></tr>";
}
?>
