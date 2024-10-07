<?php 
require_once($_SERVER['DOCUMENT_ROOT'] . '/tulipe/conn/dbConnect.php');

if(isset($_GET['id'])){
    $id = $_GET['id'];

    // Fetch the tulipe data based on ID
    $stmt = $pdo->prepare("SELECT * FROM tulipes WHERE id = ?");
    $stmt->execute([$id]);
    $res = $stmt->fetch(PDO::FETCH_ASSOC);

    if(isset($_POST['submit'])){
        $quantite = $_POST['quantite'];
        $prix = $_POST['prix'];
        $moyen_de_paiement = $_POST['moyen_de_paiement'];
        $est_paye = isset($_POST['est_paye']) ? 1 : 0;
        $idusers = $_POST['idusers'];
        $signature = $_POST['signature'];

        // Update tulipe data
        $stmt = $pdo->prepare("UPDATE tulipes SET quantite = ?, prix = ?, moyen_de_paiement = ?, est_paye = ?, idusers = ?, signature = ? WHERE id = ?");
        $stmt->execute([$quantite, $prix, $moyen_de_paiement, $est_paye, $idusers, $signature, $id]);

        header("Location: /tulipe/crud/tulipes/index.php");
    }
}
?>

<!DOCTYPE html>
<html>
<body>

    <h2>Modifier la Tulipe</h2>
    <form action="edit.php?id=<?php echo $id; ?>" method="post">
        <label>Quantité:</label><br>
        <input type="number" name="quantite" value="<?php echo $res['quantite']; ?>" required><br>
        <label>Prix:</label><br>
        <input type="text" name="prix" value="<?php echo $res['prix']; ?>" required><br>
        <label>Moyen de paiement:</label><br>
        <input type="text" name="moyen_de_paiement" value="<?php echo $res['moyen_de_paiement']; ?>" required><br>
        <label>Est payé:</label><br>
        <input type="checkbox" name="est_paye" <?php echo ($res['est_paye'] ? 'checked' : ''); ?>><br>
        <label>ID Utilisateur:</label><br>
        <input type="number" name="idusers" value="<?php echo $res['idusers']; ?>" required><br>
        <label>Signature:</label><br>
        <input type="text" name="signature" value="<?php echo $res['signature']; ?>"><br><br>
        <input type="submit" name="submit" value="Modifier">
    </form>

</body>
</html>
