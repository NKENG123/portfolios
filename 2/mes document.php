

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="mes document.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
   
    <nav>
    <a href="accueil.php">Accueil</a>

    <a href="deconnexion.php">Se déconnecter</a>
</nav>
    <?php
 session_start();
 include "conn.php";

 if (!isset($_SESSION['user_id'])) {
    header("Location: connexion.php");
    exit;
 }

 
 $stmt = $conn->prepare("SELECT * FROM ajout_document WHERE user_id = :user_id ORDER BY type DESC");

 $stmt->execute([':user_id' => $_SESSION['user_id']]);
 $documents = $stmt->fetchAll(PDO::FETCH_ASSOC);
 ?>  
 </head>


<button class= "btm" onclick="window.print()">Imprimer la liste des documents</button>

    <table>
        <thead>
            <tr>
                <th>Titre</th>
                <th>Type</th>
                <th>Description</th>
                <th>Date</th>
                <th>Fichier</th>
                <th>Modifier</th>
                <th>Supprimer</th>
                <th>Imprimer</th>

            </tr>
        </thead>
        <tbody>
            <?php if (count($documents) > 0): ?>
                <?php foreach ($documents as $doc): ?>
                    <tr>
                        <td><?= htmlspecialchars($doc['titre']) ?></td>
                        <td><?= htmlspecialchars($doc['type']) ?></td>
                        <td><?= nl2br(htmlspecialchars($doc['description'])) ?></td>
                        <td><?= htmlspecialchars($doc['date']) ?></td>
                        <td><a class="btn" href="<?= htmlspecialchars($doc['fichier']) ?>" target="_blank">Voir</a></td>
                        <td><a class="btn" href="modifier.php?id=<?= $doc['id'] ?>">Modifier</a></td>
                        <td><a class="btn" href=" supprimer.php?id=<?= $doc['id'] ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce document ?');"> Supprimer</a></td>
                        <td><a class="btn" href="<?php echo $doc['fichier']; ?>" target="_blank">Imprimer document</a></td>
                    
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="5">Aucun document trouvé.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>


 </html>

   
</body>

</html>