<?php require_once (($_SERVER['DOCUMENT_ROOT'] . '/tulipe/headFoot/header.php'))?>

<body background="/tulipe/img/wallpaper-tulipe.jpg">
<div class="container">
	<div class="card">
		<div class="card-image">	
			<h2 class="card-heading">
				Se connecter 
			</h2>
		</div>
		<form class="card-form" action="login.php" method="POST">
			<div class="input">
				<input type="text" class="input-field" name="login" id="login" required/>
				<label class="input-label" for="login">Login</label>
			</div>

			<div class="input">
				<input type="email" class="input-field" name="email" id="email" required/>
				<label class="input-label" for="email">Email</label>
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

<?php
session_start();
include "../conn/dbConnect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = $_POST['login'];
	$email = $_POST['email'];
    $password = $_POST['password'];

    try {
		// Préparation de la requête pour récupérer les informations de l'utilisateur
		$stmt = $pdo->prepare("SELECT * FROM users WHERE username=?");
		$stmt->execute([$username]);

		if ($stmt->rowCount() > 0) {
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			$hashed_password = $row['password']; // Récupération du mot de passe haché

			// Vérification du mot de passe haché avec password_verify()
			if (password_verify($password, $hashed_password)) {
				$id = $row['id'];
				$role = $row['role'];

				session_start();
				$_SESSION['username'] = $username;
				$_SESSION['id'] = $id;
				$_SESSION['role'] = $role;

				header("Location:../index.php");
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
