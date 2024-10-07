<?php 
require_once($_SERVER['DOCUMENT_ROOT'] . '/tulipe/conn/dbConnect.php');

if(isset($_GET['id'])){
    $id = $_GET['id'];

    // Delete the tulipe data
    $stmt = $pdo->prepare("DELETE FROM tulipes WHERE id = ?");
    $stmt->execute([$id]);

    header("Location: /tulipe/crud/tulipes/index.php");
}
?>
