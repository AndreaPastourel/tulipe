<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . '/tulipe/conn/dbConnect.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/tulipe/headFoot/header.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/tulipe/navbar/navbar.php');

// Vérifiez si les clés de session existent
if (!isset($_SESSION['id']) || !isset($_SESSION['username'])) {
    echo "Erreur: Identifiant de session non défini.";
    exit();
}

// Récupérer l'id de l'utilisateur et son rôle
$userId = $_SESSION['id'];
$userRole = $_SESSION['role'];

// Préparer la requête pour récupérer les tulipes en fonction du rôle de l'utilisateur
if ($userRole == "Professeur") {
    // Le professeur voit toutes les tulipes avec les informations de groupe
    $stmt = $pdo->prepare("SELECT tulipes.*, users.groupe FROM tulipes INNER JOIN users ON tulipes.idusers = users.id ORDER BY users.groupe");
    $stmt->execute();
    $tulipes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else if ($userRole == "Eleve") {
    // Un élève ne voit que ses propres tulipes
    $stmt = $pdo->prepare("SELECT tulipes.*, users.groupe FROM tulipes INNER JOIN users ON tulipes.idusers = users.id WHERE tulipes.idusers = ?");
    $stmt->execute([$userId]);
    $tulipes = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

?>

<!DOCTYPE html>
<html>
<body background="/tulipe/img/wallpaper-tulipe.jpg">
    <div class="crud">
        <h1>CRUD Tulipes</h1>
        <p><a href="/tulipe/crud/tulipe/add.php">Ajouter des Commande</a></p>
        <table>
            <tr>
                <th>ID</th>
                <th>Groupe</th>
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
                    // Affichage sécurisé des données avec htmlspecialchars
                    echo "<td>" . htmlspecialchars($tulipe['id']) . "</td>";
                    echo "<td>" . htmlspecialchars($tulipe['groupe'] ?? 'Non spécifié') . "</td>"; // Null coalescing pour gérer les valeurs manquantes
                    echo "<td>" . htmlspecialchars($tulipe['quantite'] ?? 'Non spécifié') . "</td>";
                    echo "<td>" . htmlspecialchars($tulipe['prix'] ?? 'Non spécifié') . "</td>";
                    echo "<td>" . htmlspecialchars($tulipe['moyen_de_paiement'] ?? 'Non spécifié') . "</td>";
                    echo "<td>" . ($tulipe['est_paye'] ? 'Oui' : 'Non') . "</td>";
                    
                    // Gestion des signatures (image), en évitant les erreurs si 'signature' est vide
                    if (!empty($tulipe['signature'])) {
                        echo "<td><img src='/tulipe/uploads/" . htmlspecialchars($tulipe['signature']) . "' alt='" . htmlspecialchars($tulipe['signature']) . "' style='width:50px;height:50px;'></td>";
                    } else {
                        echo "<td>Pas de signature</td>";
                    }

                    // Liens pour modifier et supprimer les tulipes
                    echo "<td><a href='edit.php?id=" . htmlspecialchars($tulipe['id']) . "'>Modifier</a> | 
                              <a href='delete.php?id=" . htmlspecialchars($tulipe['id']) . "' onClick='return confirm(\"Êtes-vous sûr de vouloir supprimer ?\")'>Supprimer</a></td>";
                    echo "</tr>";
                }
            } else {
                // Message si aucune tulipe n'est trouvée
                echo "<tr><td colspan='8'>Aucune tulipe trouvée.</td></tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>
