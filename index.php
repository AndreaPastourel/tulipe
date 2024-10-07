<?php
 if (session_status() == PHP_SESSION_NONE) {
 session_start();}
 if (!isset($_SESSION['id'])){
    header("Location: /tulipe/logreg/login.php");
 } else{
    header("Location: /tulipe/crud/tulipe/crudTulipe.php");
 }
?>