<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="connexion.css">
    <meta name="viewport" content="width=, initial-scale=1.0, user-scalable=no">
    <title>gestion de document</title>

</head>
<body>
    </center>
<?php
session_start(); // Démarrer une session pour gérer la connexion de l'utilisateur
include "conn.php"; // Assure-toi d'avoir une connexion à la base de données

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données envoyées par le formulaire
    $email = htmlspecialchars(trim($_POST['email']));
    $password = $_POST['password'];

    // Vérifier si l'email existe dans la base de données
    $stmt = $conn->prepare("SELECT * FROM inscription WHERE email = :email");
    $stmt->execute([':email' => $email]);

    // Si l'email est trouvé dans la base de données
    if ($stmt->rowCount() > 0) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC); // Récupérer les données de l'utilisateur
        // Vérifier si le mot de passe est correct
        if (password_verify($password, $user['password'])) {
            // Si les mots de passe correspondent, créer une session pour l'utilisateur
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $user['email'];

            // Rediriger vers la page protégée ou d'accueil
            echo "<script>alert('Connexion réussie !'); window.location='accueil.php';</script>";
        } else {
            // Si le mot de passe ne correspond pas
            echo "<script>alert('Mot de passe incorrect.');</script>";
        }
    } else {
        // Si l'email n'est pas trouvé
        echo "<script>alert('Aucun utilisateur trouvé avec cet email.');window.location='authen.php';</script>";
    }
}
?>

<nav>
   
    <a href="authen.php">Inscription</a>
   
</nav>
<div class = "container">

    <h2>Connexion au compte </h2>
    <fieldset>
    <form action="" method = "post">
        <table>
        <tr>
            <td>email : </td> <td><input type="email" name="email" placeholder="email"required></td>
        </tr>
        <tr>
            <td>mot de passe confirme: </td><td><input type="password" name="password" placeholder="password"required></td>
        </tr>
       
        <button type="submit" name="connexion">Connexion</button>
         
    
    </table>
    </form>
</fieldset>

</div>

</body>
</center>
</html>