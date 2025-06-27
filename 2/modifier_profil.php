<?php
session_start();
include "conn.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: connexion.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = htmlspecialchars($_POST['nom']);
    $prenom = htmlspecialchars($_POST['prenom']);
    $email = htmlspecialchars($_POST['email']);
    $telephone = htmlspecialchars($_POST['telephone']);

    $stmt = $conn->prepare("UPDATE inscription SET nom = :nom, prenom = :prenom, email = :email, telephone = :telephone WHERE id = :id");
    $stmt->execute([
        ':nom' => $nom,
        ':prenom' => $prenom,
        ':email' => $email,
        ':telephone' => $telephone,
        ':id' => $_SESSION['user_id']
    ]);

    echo "<script>alert('Informations mises à jour avec succès !'); window.location.href = 'parametre.php';</script>";
    exit;
}
?>
