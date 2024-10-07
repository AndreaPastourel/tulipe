<?php 
   // if (session_status() == PHP_SESSION_NONE) {
    //session_start();}
    //if(!isset($_SESSION['username']) || $_SESSION['role']!="Professeur"){
      //header("Location: /tulipe/unauthorized.php");
        //exit();
    //}
    ?>

<?php require_once (($_SERVER['DOCUMENT_ROOT'] . '/tulipe/headFoot/header.php'))?>


<body background="/tulipe/img/wallpaper-tulipe.jpg">

<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/tulipe/conn/dbConnect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $groupe = $_POST['groupe'] ?? '';
    $email = $_POST['email'] ?? '';
    $login = $_POST['login'] ?? '';
    $password = $_POST['password'] ?? '';
    $role = $_POST['role'] ?? '';

    // Hachage du mot de passe
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Validation de l'adresse e-mail
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<p style='color:red;'>Format de l'adresse e-mail invalide</p>";
    } else {
        try {
            // Préparer et exécuter la requête d'insertion
            $stmt = $pdo->prepare("INSERT INTO users (groupe,login,email,password,role) VALUES (?, ?, ?, ?,?)");
            $stmt->execute([$groupe,$login,$email, $hashed_password,$role]);

            // Message de succès
            $messageValide="<p style='color:green;'>L'utilisateur $login a été ajouté avec succès.</p>";
        } catch (PDOException $e) {
           $messageErreur="<p style='color:red;'>ERREUR: " . $e->getMessage() . "</p>";
        }
    }
}
?>


<div class="crud">

    <!-- Formulaire pour ajouter un utilisateur (inclus via require_once) -->
    <?php require_once($_SERVER['DOCUMENT_ROOT'] . '/tulipe/crud/user/add.php'); ?>

</div>

</body>
</html>