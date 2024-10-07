<?php 
// Ensure session security for admin access
// if (session_status() == PHP_SESSION_NONE) {
//     session_start();
// }
// if(!isset($_SESSION['username']) || $_SESSION['role'] != "admin"){
//     header("Location: /arrasGames/unauthorized.php");
//     exit();
// }
?>

<?php require_once ($_SERVER['DOCUMENT_ROOT'] . '/tulipe/headFoot/header.php'); ?>

<?php
// Include the database connection
require_once($_SERVER['DOCUMENT_ROOT'] . '/tulipe/conn/dbConnect.php');

// Query to retrieve tulipes data
$stmt = $pdo->query("SELECT * FROM tulipes ORDER BY id");
?>

<!DOCTYPE html>
<html>

<body background="/tulipe/img/wallpaper-tulipe.jpg">

    <div class="crud">
        <h1>CRUD Tulipes</h1>
        <p><a href="add.php">Ajouter des tulipes</a></p>

        <!-- Start of CRUD table -->
        <table>
            <tr>
                <td>ID</td>
                <td>Quantité</td>
                <td>Prix</td>
                <td>Moyen de paiement</td>
                <td>Est payé</td>
                <td>Utilisateur ID</td>
                <td>Signature</td>
                <td>Action</td>
            </tr>
            <?php
            // Fetch tulipes data and display it
            while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
                echo "<tr>";
                    echo "<td>".$res['id']."</td>";
                    echo "<td>".$res['quantite']."</td>";
                    echo "<td>".$res['prix']."</td>";
                    echo "<td>".$res['moyen_de_paiement']."</td>";
                    echo "<td>".($res['est_paye'] ? 'Oui' : 'Non')."</td>";
                    echo "<td>".$res['idusers']."</td>";
                    echo "<td>".($res['signature'] !== NULL ? $res['signature'] : 'NULL')."</td>";
                    echo "<td> <a href=\"edit.php?id={$res['id']}\">Modifier</a> | 
                              <a href=\"delete.php?id={$res['id']}\" onClick=\"return confirm('Etes-vous sûr de vouloir supprimer?')\">Supprimer</a></td>";
                echo "</tr>";
            }
            ?>
        </table>
        <!-- End of CRUD table -->
    </div>

</body>
</html>
