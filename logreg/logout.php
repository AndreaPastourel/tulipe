<?php
session_start(); // Démarrer la session

// Détruire toutes les variables de session
$_SESSION = [];

// Si vous voulez détruire également la session, appelez session_destroy()
session_destroy();

// Rediriger l'utilisateur vers la page de connexion ou la page d'accueil
header("Location: /tulipe/logreg/login.php"); 
exit();
?>
