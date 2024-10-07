<?php 
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . '/tulipe/conn/dbConnect.php');

// Vérifier que l'utilisateur est connecté
if (!isset($_SESSION['username'])) {
    header("Location: /tulipe/login.php");
    exit();
}

// Requête pour récupérer les tulipes de l'utilisateur courant
$stmt = $pdo->prepare("SELECT * FROM tulipes WHERE idusers = ?");
$stmt->execute([$_SESSION['id']]);
?>

<!DOCTYPE html>
<html>
<body>

    <h1>CRUD Tulipes - Utilisateur: <?php echo $_SESSION['username']; ?></h1>
    <p><a href="add.php">Ajouter des tulipes</a></p>

    <table border="1">
        <tr>
            <th>ID</th>
            <th>Quantité</th>
            <th>Prix</th>
            <th>Moyen de paiement</th>
            <th>Est payé</th>
            <th>Signature</th>
            <th>Action</th>
        </tr>
        <?php
        while($res = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>".$res['id']."</td>";
            echo "<td>".$res['quantite']."</td>";
            echo "<td>".$res['prix']."</td>";
            echo "<td>".$res['moyen_de_paiement']."</td>";
            echo "<td>".($res['est_paye'] ? 'Oui' : 'Non')."</td>";
            echo "<td>".($res['signature'] ? $res['signature'] : 'NULL')."</td>";
            echo "<td>
                    <a href=\"edit.php?id={$res['id']}\">Modifier</a> | 
                    <a href=\"delete.php?id={$res['id']}\" onClick=\"return confirm('Êtes-vous sûr de vouloir supprimer ?')\">Supprimer</a>
                  </td>";
            echo "</tr>";
        }
        ?>
    </table>
</body>
</html>
