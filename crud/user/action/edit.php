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
?>

<!DOCTYPE html>
<html>
<body background="/tulipe/img/wallpaper-tulipe.jpg">



   <?php 
   if (isset($_POST['update'])) {
        $id = $_POST['id'];
        $groupe = $_POST['groupe'];
        $login = $_POST['login'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        $role = $_POST['role'];

        // Hachage du mot de passe seulement si le mot de passe a été changé
        if (password_needs_rehash($password, PASSWORD_DEFAULT)) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        } else {
            $hashed_password = $password;
        }

        try {
            $stmt = $pdo->prepare("UPDATE users SET groupe=?, login=?,password=?, email=?, role=? WHERE id=?");
            $stmt->execute([$groupe, $login,$hashed_password, $email, $role, $id]);
            echo "<h2>L'utilisateur $login a bien été mis à jour!</h2>";
            
        } catch (PDOException $e) {
            echo "ERREUR : " . $e->getMessage();
        }
    }
   ?>
   <p><a href="/tulipe/crud/user/crudUser.php">Retour sur le Crud</a></p>
  </div>
</div>


</body>
</html>