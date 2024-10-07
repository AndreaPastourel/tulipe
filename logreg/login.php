
<?php require_once (($_SERVER['DOCUMENT_ROOT'] . '/tulipe/headFoot/header.php'))?>

<body background="/tulipe/img/wallpaper-tulipe.jpg">
<div class="container">
	<!-- code here -->
	<div class="card">
		<div class="card-image">	
			<h2 class="card-heading">
				Se connecter 
			</h2>
		</div>
		<form class="card-form">
			<div class="input">
				<input type="text" class="input-field" required/>
				<label class="input-label" name ="login" id="login">Login</label>
			</div>

			<div class="input">
				<input type="text" class="input-field" required/>
				<label class="input-label" name ="email" id="login">Email</label>
			</div>

						<div class="input">
				<input type="password" class="input-field" required/>
				<label class="input-label" name="password" id="password">Mot de passe</label>
			</div>
			<div class="action">
				<button class="action-button">Se connecter</button>
			</div>
		</form>
		<div class="card-info">
			<p>En vous inscrivant, vous acceptez nos <a href="#">conditions générales</a></p>
		</div> 
	</div>
</div></body> 

<?php

session_start();
include "../conn/dbConnect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    try {
       
        $sql = "SELECT * FROM utilisateurs WHERE nom_utilisateur = :username";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

         
            if (password_verify($password, $user['mot_de_passe'])) {
                $_SESSION['username'] = $user['nom_utilisateur'];
                $_SESSION['role'] = $user['role'];
                echo "Vous êtes connecté en tant que " . $username;
                header("Location: ../admin/consulter_tournois.php");
                exit();
            } else {
                echo "Votre nom d'utilisateur ou votre mot de passe est incorrect";
            }
        } else {
            echo "Votre nom d'utilisateur ou votre mot de passe est incorrect";
        }
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}
?>

