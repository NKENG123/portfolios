<?php
session_start();
include "conn.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: connexion.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $actuel = $_POST['actuel'];
    $nouveau = $_POST['nouveau'];
    $confirmer = $_POST['confirmer'];

    if ($nouveau !== $confirmer) {
        echo "<script>alert('Les mots de passe ne correspondent pas.'); window.location.href='parametre.php';</script>";
        exit;
    }

    // Vérifier l'ancien mot de passe
    $stmt = $conn->prepare("SELECT mot_de_passe FROM inscription WHERE id = :id");
    $stmt->execute([':id' => $_SESSION['user_id']]);
    $user = $stmt->fetch();

    if ($user && password_verify($actuel, $user['mot_de_passe'])) {
        $hashedPassword = password_hash($nouveau, PASSWORD_DEFAULT);

        $updateStmt = $conn->prepare("UPDATE inscription SET mot_de_passe = :mdp WHERE id = :id");
        $updateStmt->execute([
            ':mdp' => $hashedPassword,
            ':id' => $_SESSION['user_id']
        ]);

        echo "<script>alert('Mot de passe modifié avec succès !'); window.location.href='parametre.php';</script>";
    } else {
        echo "<script>alert('Mot de passe actuel incorrect.'); window.location.href='parametre.php';</script>";
    }
}
?>
