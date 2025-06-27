
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="authen.css">
    <meta name="viewport" content="width=, initial-scale=1.0, user-scalable=no">
    <title>gestion de document</title>
   

</head>
<body>
<?php

include "conn.php"; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    $nom = htmlspecialchars(trim($_POST['nom']));
    $prenom = htmlspecialchars(trim($_POST['prenom']));
    $email = htmlspecialchars(trim($_POST['email']));
    $telephone = htmlspecialchars(trim($_POST['telephone']));
    $password = $_POST['password'];
    $confirmpassword = $_POST['confirmpassword'];

   
    $stmt_email = $conn->prepare("SELECT * FROM inscription WHERE email = :email");
    $stmt_email->execute([':email' => $email]);

  
    $stmt_telephone = $conn->prepare("SELECT * FROM inscription WHERE telephone = :telephone");
    $stmt_telephone->execute([':telephone' => $telephone]);

    if ($stmt_email->rowCount() > 0) {
        echo "<script>alert('Cet email est déjà utilisé.');</script>";
    } elseif ($stmt_telephone->rowCount() > 0) {
        echo "<script>alert('Ce numéro de téléphone est déjà utilisé.');</script>";
    } else {
       
        if ($password === $confirmpassword) {
          
            $sql = "INSERT INTO inscription (nom, prenom, email, telephone, password) VALUES (:nom, :prenom, :email, :telephone, :password)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                ':nom' => $nom,
                ':prenom' => $prenom,
                ':email' => $email,
                ':telephone' => $telephone,
                ':password' => password_hash($password, PASSWORD_DEFAULT)
            ]);

           
            echo "<script>alert('Inscription réussie !'); window.location='connexion.php';</script>";
        } else {
           
            echo "<script>alert('Les mots de passe ne correspondent pas.');</script>";
        }
    }
}
?>



<div class = "container">

        <h2>Inscription  </h2>
    
    <form  action="" method="POST">
        <table>
            <tr>
                <td><label for="nom">nom : </label></td><td><input type="text" id="nom" name="nom" placeholder="nom" required></td>
                </tr>
                <tr>
                <td><label for="prenom">prenom : </label></td> <td><input type="text" id="prenom" name="prenom" placeholder="prenom"required></td>
            </tr>
            <tr>
                <td><label for="email">email : </label></td> <td><input type="email" id="email" name="email" placeholder="email"required></td>
            </tr>
            <tr>
                <td><label for="telephone">telephone : </label></td><td><input type="number" id="telephone" name="telephone" placeholder="telepone" title="Entrez un numéro entre 8 et 15 chiffres" required></td>
            </tr>
            <tr>
                <td><label for="password">mot de passe : </label></td><td><input type="password" id="password" name="password" placeholder="password" required></td>
            </tr>
            
            <tr>
                <td><label for="confirmpassword">mot de passe confirme: </label></td><td><input type="password" id="confirmpassword" name="confirmpassword" placeholder="password"required ></td>
            </tr>
             
             <button type="submit" name="inscrire">S'incrire</button>
            

        </table>
    </form>



</div>

</body>
</html>