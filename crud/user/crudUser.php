<?php 
    //if (session_status() == PHP_SESSION_NONE) {
   // session_start();}
   //if(!isset($_SESSION['username']) || $_SESSION['role']!="professeur"){
    //  header("Location: /tulipe/unauthorized.php");
    //   exit();
    //}
    ?>


<?php require_once (($_SERVER['DOCUMENT_ROOT'] . '/tulipe/headFoot/header.php'))?>


<?php
//Include the database connection file
require_once(($_SERVER['DOCUMENT_ROOT'] . '/tulipe/conn/dbConnect.php'));

//Requete pour recuperer les utilisateurs 
$stmt=$pdo->query("SELECT * FROM users ORDER BY id");
?>

<!DOCTYPE html>
<html>


<body background="/tulipe/img/wallpaper-tulipe.jpg">

    <div class="crud">
    <h1>CRUD utilisateurs</h1>
    <p><a href="/tulipe/crud/user/add.php">Ajouter des utilisateurs</a></p>

    <!-- Debut du tableau crud -->
    <table>
        <tr>
            <td>ID</td>
            <td>Groupe</td>
            <td>Login</td>
            <td>Email</td>
            <td>Password</td>
            <td>Role</td>
            <td>Action</td>
        </tr>
        <?php
        //boucles d'affichage
        while($res=$stmt->fetch(PDO::FETCH_ASSOC)){
            echo "<tr>";
                echo "<td>".$res['id']."</td>";
                echo "<td>".$res['groupe']."</td>";
                echo "<td>".$res['login']."</td>";
                echo "<td>".$res['email']."</td>";
                 // Afficher toujours 8 astérisques pour la colonne mot de passe
                 echo "<td>********</td>";
                echo "<td>".$res['role']."</td>";
                echo "<td> <a href=\"/tulipe/crud/user/edit.php?id={$res['id']}\">Modifier</a> | 
                          <a href=\"/tulipe/crud/user/delete.php?id={$res['id']}\" onClick=\"return confirm('Etes vous sur de supprimer?')\">Supprimer</a></td>";
            echo "</tr>";
        }
        ?>
    </table>
    <!--Fin du tableau crud-->
     
    </div>
 



</body>



</html>