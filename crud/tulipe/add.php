<?php 
require_once($_SERVER['DOCUMENT_ROOT'] . '/tulipe/conn/dbConnect.php');

if(isset($_POST['submit'])){
    $quantite = $_POST['quantite'];
    $prix = $_POST['prix'];
    $moyen_de_paiement = $_POST['moyen_de_paiement'];
    $est_paye = isset($_POST['est_paye']) ? 1 : 0;
    $idusers = $_POST['idusers'];
    $signature = $_POST['signature'];

    // Insert into database
    $stmt = $pdo->prepare("INSERT INTO tulipes (quantite, prix, moyen_de_paiement, est_paye, idusers, signature) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$quantite, $prix, $moyen_de_paiement, $est_paye, $idusers, $signature]);

    header("Location: /tulipe/crud/tulipes/index.php");
}
?>

<!DOCTYPE html>
<html>
<body>

    <h2>Ajouter une Tulipe</h2>
    <form action="add.php" method="post">
        <label>Quantité:</label><br>
        <input type="number" name="quantite" required><br>
        <label>Prix:</label><br>
        <input type="text" name="prix" required><br>
        <label>Moyen de paiement:</label><br>
        <input type="text" name="moyen_de_paiement" required><br>
        <label>Est payé:</label><br>
        <input type="checkbox" name="est_paye"><br>
        <label>ID Utilisateur:</label><br>
        <input type="number" name="idusers" required><br>
        <label>Signature:</label><br>
        <input type="text" name="signature"><br><br>
        <input type="submit" name="submit" value="Ajouter">
    </form>

</body>
</html>
