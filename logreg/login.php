
<?php require_once (($_SERVER['DOCUMENT_ROOT'] . '/tulipe/headFoot/header.php'))?>

<body background="/tulipe/img/wallpaper-tulipe.jpg">
<div class="container">
	<!-- code here -->
	<div class="card">
		<div class="card-image">	
			<h2 class="card-heading">
				Se connecter
				<small>Let us create your account</small>
			</h2>
		</div>
		<form class="card-form">
			<div class="input">
				<input type="text" class="input-field" value="Alexander Parkinson" required/>
				<label class="input-label">Full name</label>
			</div>
						<div class="input">
				<input type="text" class="input-field" value="vlockn@gmail.com" required/>
				<label class="input-label">Email</label>
			</div>
						<div class="input">
				<input type="password" class="input-field" required/>
				<label class="input-label">Mot de passe</label>
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
