<?php
   require_once($_SERVER['DOCUMENT_ROOT'] . '/tulipe/conn/dbConnect.php');
    $id=$_GET['id'];

    try{
        $stmt=$pdo->prepare("DELETE FROM tulipe WHERE iduser=?");
        $stmt->execute([$id]);

        header("Location: /tulipe/crud/user/crudUser.php");
    } catch(PDOException $e){
        echo"ERREUR: ".$e->getMessage();
    }
    try{
        $stmt=$pdo->prepare("DELETE FROM users WHERE id=?");
        $stmt->execute([$id]);

        header("Location: /tulipe/crud/user/crudUser.php");
    } catch(PDOException $e){
        echo"ERREUR: ".$e->getMessage();
    }
?>