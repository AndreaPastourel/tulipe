<?php 
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . '/tulipe/conn/dbConnect.php');

if (!isset($_SESSION['username'])) {
    header("Location: /tulipe/login.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Récupérer les informations de la tulipe à modifier
    $stmt = $pdo->prepare("SELECT * FROM tulipes WHERE id = ? AND idusers = ?");
    $stmt->execute([$id, $_SESSION['id']]);
    $res = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$res) {
        echo "Tulipe non trouvée ou accès non autorisé.";
        exit();
    }

    if (isset($_POST['submit'])) {
        $quantite = $_POST['quantite'];
        $prix = $_POST['prix'];
        $moyen_de_paiement = $_POST['moyen_de_paiement'];
        $est_paye = isset($_POST['est_paye']) ? 1 : 0;
        $signature = $_POST['signature'];

        // Mise à jour de la tulipe
        $stmt = $pdo->prepare("UPDATE tulipes SET quantite = ?, prix = ?, moyen_de_paiement = ?, est_paye = ?, signature = ? WHERE id = ?");
        $stmt->execute([$quantite, $prix, $moyen_de_paiement, $est_paye, $signature, $id]);

        header("Location: index.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Modifier la Tulipe</title>
</head>
<body>
    <h2>Modifier la Tulipe</h2>
    <form method="post" action="edit.php?id=<?php echo $id; ?>">
        <label>Quantité:</label><br>
        <input type="number" name="quantite" value="<?php echo $res['quantite']; ?>" required><br>
        
        <label>Prix:</label><br>
        <input type="text" name="prix" value="<?php echo $res['prix']; ?>" required><br>
        
        <label>Moyen de paiement:</label><br>
        <input type="text" name="moyen_de_paiement" value="<?php echo $res['moyen_de_paiement']; ?>" required><br>
        
        <label>Est payé:</label><br>
        <input type="checkbox" name="est_paye" <?php if ($res['est_paye']) echo 'checked'; ?>><br>
        
        <label>Signature:</label><br>
        <input type="text" name="signature" value="<?php echo $res['signature']; ?>" required><br>
        
        <input type="submit" name="submit" value="Mettre à jour">
    </form>
</body>
</html>
