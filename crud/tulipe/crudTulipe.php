<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . '/tulipe/conn/dbConnect.php');
require_once (($_SERVER['DOCUMENT_ROOT'] . '/tulipe/headFoot/header.php'));
require_once (($_SERVER['DOCUMENT_ROOT'] . '/tulipe/navbar/navbar.php'));


// Vérifiez si les clés de session existent
if (!isset($_SESSION['id']) || !isset($_SESSION['username'])) {
    echo "Erreur: Identifiant de session non défini.";
    exit();
}

// Récupérer l'id de l'utilisateur
$userId = $_SESSION['id'];
$userRole = $_SESSION['role'];

// Préparer la requête pour récupérer les tulipes de l'utilisateur
if  ($userRole=="Professeur"){
$stmt = $pdo->prepare("SELECT * FROM tulipes WHERE idusers = ?");
$stmt->execute([$userId]);
$tulipes = $stmt->fetchAll(PDO::FETCH_ASSOC);}

else if($userRole=="Eleve"){
    $stmt = $pdo->prepare("SELECT * FROM tulipes WHERE idusers = ?");
    $stmt->execute([$userId]);
    $tulipes = $stmt->fetchAll(PDO::FETCH_ASSOC);}

?>

<!DOCTYPE html>
<html>
<body background="/tulipe/img/wallpaper-tulipe.jpg">
    <div class="crud">
        <h1>CRUD Tulipes </h1>
        <p><a href="/tulipe/crud/tulipe/add.php">Ajouter des Commande</a></p>
        <table>
            <tr>
                <th>ID</th>
                <th>Quantité</th>
                <th>Prix</th>
                <th>Moyen de paiement</th>
                <th>Est payé</th>
                <th>Signature</th>
                <th>Action</th>
            </tr>
            <?php
            // Vérifiez si des tulipes ont été récupérées
            if ($tulipes) {
                foreach ($tulipes as $tulipe) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($tulipe['id']) . "</td>";
                    echo "<td>" . htmlspecialchars($tulipe['quantite']) . "</td>";
                    echo "<td>" . htmlspecialchars($tulipe['prix']) . "</td>";
                    echo "<td>" . htmlspecialchars($tulipe['moyen_de_paiement']) . "</td>";
                    echo "<td>" . ($tulipe['est_paye'] ? 'Oui' : 'Non') . "</td>";
                    echo "<td>" . htmlspecialchars($tulipe['signature']) . "</td>";
                    echo "<td><a href='edit.php?id=" . $tulipe['id'] . "'>Modifier</a> | <a href='delete.php?id=" . $tulipe['id'] . "' onClick='return confirm(\"Etes vous sûr de vouloir supprimer ?\")'>Supprimer</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>Aucune tulipe trouvée.</td></tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>
