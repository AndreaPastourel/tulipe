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
    $stmt = $pdo->prepare("SELECT * FROM tulipes WHERE id = ?");
    $stmt->execute([$id]);
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

        // Gérer la mise à jour de la signature s'il y a un fichier uploadé
        if (!empty($_FILES['signature']['name'])) {
            $signature_tmp = $_FILES['signature']['tmp_name'];
            $signature_name = 'signature_' . time() . '.png';  // Nom unique pour éviter les collisions
            move_uploaded_file($signature_tmp, $_SERVER['DOCUMENT_ROOT'] . '/tulipe/uploads/' . $signature_name);
        } else {
            // Si aucune nouvelle signature n'est fournie, garder l'ancienne
            $signature_name = $res['signature'];
        }

        // Mise à jour de la tulipe
        $stmt = $pdo->prepare("UPDATE tulipes SET quantite = ?, prix = ?, moyen_de_paiement = ?, est_paye = ?, signature = ? WHERE id = ?");
        $stmt->execute([$quantite, $prix, $moyen_de_paiement, $est_paye, $signature_name, $id]);

        header("Location: index.php");
        exit();
    }
}
?>
<?php require_once (($_SERVER['DOCUMENT_ROOT'] . '/tulipe/headFoot/header.php'))?>
<!DOCTYPE html>
<html>
<?php require_once ($_SERVER['DOCUMENT_ROOT'] . '/tulipe/navbar/navbar.php');?>
<head>
    <title>Modifier la Tulipe</title>
</head>
<body background="/tulipe/img/wallpaper-tulipe.jpg">
<div class='form'>
    <h2>Modifier la Tulipe</h2>
    <form method="post" action="edit.php?id=<?php echo $id; ?>" enctype="multipart/form-data">
        <table>
            <tr>
                <td><label>Quantité:</label></td>
                <td><input type="number" name="quantite" value="<?php echo htmlspecialchars($res['quantite']); ?>" required></td>
            </tr>
            <tr>
                <td><label>Prix:</label></td>
                <td><input type="text" name="prix" value="<?php echo htmlspecialchars($res['prix']); ?>" required></td>
            </tr>
            <tr>
                <td><label>Moyen de paiement:</label></td>
                <td><input type="text" name="moyen_de_paiement" value="<?php echo htmlspecialchars($res['moyen_de_paiement']); ?>" required></td>
            </tr>
            <tr>
                <td><label>Est payé:</label></td>
                <td><input type="checkbox" name="est_paye" <?php if ($res['est_paye']) echo 'checked'; ?>></td>
            </tr>
            <tr>
                <td><label>Signature actuelle:</label></td>
                <td>
                    <?php if (!empty($res['signature'])): ?>
                        <img src="/tulipe/uploads/<?php echo htmlspecialchars($res['signature']); ?>" alt="Signature" style="width:100px;height:100px;"><br>
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <td><label>Changer la signature (facultatif) :</label></td>
                <td><input type="file" name="signature"></td>
            </tr>
            <tr>
                <td colspan="2" style="text-align:center;">
                    <input type="submit" name="submit" value="Mettre à jour">
                </td>
            </tr>
        </table>
    </form>
    </div>
</body>
</html>