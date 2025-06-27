<?php
include 'conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    // Vérifie si l'e-mail existe
    $stmt = $conn->prepare("SELECT * FROM inscription WHERE email = :email");
    $stmt->execute([':email' => $email]);
    $user = $stmt->fetch();

    if ($user) {
        $token = bin2hex(random_bytes(32)); // Génère un token sécurisé
        $expire = date("Y-m-d H:i:s", strtotime('+1 hour'));

        // Sauvegarder le token
        $update = $conn->prepare("UPDATE inscription SET reset_token = :token, reset_expire = :expire WHERE email = :email");
        $update->execute([
            ':token' => $token,
            ':expire' => $expire,
            ':email' => $email
        ]);

        $lien = "http://votresite.com/reinitialiser.php?token=$token";

        // Tu peux envoyer le lien par mail ici
        echo "Un lien de réinitialisation a été envoyé : <a href='$lien'>$lien</a>";
    } else {
        echo "❌ Cet e-mail n'existe pas.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mot de passe oublié</title>
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

        input[type="text"], input[type="email"] {
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
    <h2>🔐 Mot de passe oublié</h2>
    <form method="POST" action="reinitialiser.php">
        <input type="text" name="identifiant" placeholder="Email ou téléphone" required>
        <button type="submit">Réinitialiser mon mot de passe</button>
    </form>

    <a href="connexion.php">← Retour à la connexion</a>

    <?php
        if (isset($_GET['erreur'])) {
            echo '<div class="message">Erreur : ' . htmlspecialchars($_GET['erreur']) . '</div>';
        }

        if (isset($_GET['success'])) {
            echo '<div class="message" style="color:green;">' . htmlspecialchars($_GET['success']) . '</div>';
        }
    ?>
</div>

</body>
</html>
