<?php 
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . '/tulipe/conn/dbConnect.php'); // Connexion à la base de données

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = $_POST['login'];
   
    $password = $_POST['password'];

    // Préparer la requête pour vérifier l'utilisateur
    $stmt = $pdo->prepare("SELECT * FROM users WHERE login = ? ");
    $stmt->execute([$login]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Vérifier si l'utilisateur existe et valider le mot de passe
    if ($user) {
        if (password_verify($password, $user['password'])) {
            $_SESSION['username'] = $user['login'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['id'] = $user['id']; 
            $_SESSION['groupe'] = $user['groupe']; 
            header("Location: /tulipe/index.php"); 
            exit();
        } else {
            echo "<p style='color:red;'>Mot de passe incorrect.</p>"; 
        }
    } else {
        echo "<p style='color:red;'>Login ou email incorrect.</p>"; 
    }
}
?>

<?php require_once (($_SERVER['DOCUMENT_ROOT'] . '/tulipe/headFoot/header.php'));
require_once (($_SERVER['DOCUMENT_ROOT'] . '/tulipe/navbar/navbar.php')); ?>

<body background="/tulipe/img/wallpaper-tulipe.jpg">
<div class="container">
    <div class="card">
        <div class="card-image">    
            <h2 class="card-heading">Se connecter</h2>
        </div>
        <form class="card-form" action="login.php" method="POST">
            <div class="input">
                <input type="text" class="input-field" name="login" id="login" required/>
                <label class="input-label" for="login">Login</label>
            </div>

           

            <div class="input">
                <input type="password" class="input-field" name="password" id="password" required/>
                <label class="input-label" for="password">Mot de passe</label>
            </div>

            <div class="action">
                <button class="action-button" type="submit">Se connecter</button>
            </div>
        </form>
        <div class="card-info">
            <p>En vous inscrivant, vous acceptez nos <a href="#">conditions générales</a></p>
        </div> 
    </div>
</div>
</body>
