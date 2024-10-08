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
$userGroupe = $_SESSION['groupe'];
$userRole = $_SESSION['role'];

// Préparer la requête pour récupérer les tulipes en fonction du rôle
if ($userRole == "Professeur") {
    // Requête pour les professeurs, récupérant toutes les tulipes avec les informations de groupe et utilisateur
    $stmt = $pdo->prepare("
        SELECT tulipes.*, users.groupe, client, adresse
        FROM tulipes 
        INNER JOIN users ON tulipes.idusers = users.id
        ORDER BY users.groupe
    ");
    $stmt->execute();
    $tulipes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} elseif ($userRole == "Eleve") {
    // Requête pour les élèves (seulement leurs propres tulipes)
    $stmt = $pdo->prepare("SELECT * FROM tulipes WHERE idusers = ?");
    $stmt->execute([$userId]);
    $tulipes = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Tulipes</title>
    <link rel="stylesheet" href="/tulipe/style.css">
</head>
<body background="/tulipe/img/wallpaper-tulipe.jpg">
    <div class="crud">
        <h1>CRUD Tulipes</h1>
        <p><a href="/tulipe/crud/tulipe/add.php">Ajouter une commande</a></p>
        <table>
            <tr>
                <th>ID</th>
                <th>Groupe</th>
                <th>Client</th>
                <th>Adresse</th>
                <th>Quantité</th>
                <th>Semaines</th> <!-- Nouvelle colonne pour les semaines -->
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
                    echo "<td>" . htmlspecialchars($tulipe['groupe']) . "</td>";
                    echo "<td>" . htmlspecialchars($tulipe['client']) . "</td>";
                    echo "<td>" . htmlspecialchars($tulipe['adresse']) . "</td>";
                    echo "<td>" . htmlspecialchars($tulipe['quantite']) . "</td>";

                      // Gestion des semaines (JSON ou tableau)
                      if (!empty($tulipe['semaines'])) {
                        $semaines = json_decode($tulipe['semaines'], true); // Décodage du JSON
                        echo "<td>" . implode(", ", $semaines) . "</td>"; // Affichage des semaines
                    } else {
                        echo "<td>Aucune semaine</td>";
                    }
                    
                    echo "<td>" . htmlspecialchars($tulipe['moyen_de_paiement']) . "</td>";
                    echo "<td>" . ($tulipe['est_paye'] ? 'Oui' : 'Non') . "</td>";
                    echo "<td>" . htmlspecialchars($tulipe['prix']) . "</td>";
                    
                  
                    
                    // Gestion des signatures (image), en évitant les erreurs si 'signature' est vide
                    if (!empty($tulipe['signature'])) {
                        echo "<td><img src='/tulipe/uploads/" . htmlspecialchars($tulipe['signature']) . "' alt='Signature' style='width:50px;height:50px;'></td>";
                    } else {
                        echo "<td>Pas de signature</td>";
                    }

                    // Liens pour modifier et supprimer les tulipes
                    echo "<td><a href='/tulipe/crud/tulipe/edit.php?id=" . htmlspecialchars($tulipe['id']) . "'>Modifier</a> | 
                              <a href='delete.php?id=" . htmlspecialchars($tulipe['id']) . "' onClick='return confirm(\"Êtes-vous sûr de vouloir supprimer ?\")'>Supprimer</a></td>";
                    echo "</tr>";
                }
            } else {
                // Message si aucune tulipe n'est trouvée
                echo "<tr><td colspan='11'>Aucune tulipe trouvée.</td></tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>