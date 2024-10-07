<?php 
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . '/tulipe/conn/dbConnect.php');

// Vérifier que l'utilisateur est connecté
if (!isset($_SESSION['username'])) {
    header("Location: /tulipe/login.php");
    exit();
}

if (isset($_POST['submit'])) {
    $quantite = $_POST['quantite'];
    $prix = $_POST['prix'];
    $moyen_de_paiement = $_POST['moyen_de_paiement'];
    $est_paye = isset($_POST['est_paye']) ? 1 : 0;
    $idusers = $_SESSION['id']; // ID de l'utilisateur courant
    $signature = $_POST['signature'];
    $groupe = $_SESSION['groupe']; // L'équipe de l'utilisateur

    // Insertion dans la base de données
    $stmt = $pdo->prepare("INSERT INTO tulipes (quantite, prix, moyen_de_paiement, est_paye, idusers, signature, groupe) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$quantite, $prix, $moyen_de_paiement, $est_paye, $idusers, $signature, $groupe]);

    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html>
<body>
    <h2>Ajouter une Tulipe</h2>
    <form method="post" action="add.php">
        <label>Quantité:</label><br>
        <input type="number" name="quantite" required><br>
        <label>Prix:</label><br>
        <input type="text" name="prix" required><br>
        <label>Moyen de paiement:</label><br>
        <input type="text" name="moyen_de_paiement" required><br>
        <label>Est payé:</label><br>
        <input type="checkbox" name="est_paye"><br>
        <label>Signature:</label><br>
        <input type="text" name="signature"><br><br>
        <input type="submit" name="submit" value="Ajouter">
    </form>
</body>
</html>
