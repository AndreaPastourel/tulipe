<?php 
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . '/tulipe/conn/dbConnect.php');

// Requête SQL pour récupérer le classement par total d'argent accumulé
$stmt = $pdo->prepare("
    SELECT u.groupe, SUM(t.prix) as total 
    FROM tulipes t 
    JOIN users u ON t.idusers = u.id
    GROUP BY u.id 
    ORDER BY total DESC
");
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Si l'utilisateur est connecté, récupérer son rang
$user_rank = null;  // Définir une valeur par défaut
if (isset($_SESSION['id'])) {
    $idusers = $_SESSION['id'];

    // Requête pour récupérer tous les utilisateurs classés par total d'argent accumulé
    $stmt_rank = $pdo->prepare("
        SELECT u.id, u.groupe, SUM(t.prix) as total 
        FROM tulipes t 
        JOIN users u ON t.idusers = u.id
        GROUP BY u.id 
        ORDER BY total DESC
    ");
    $stmt_rank->execute();
    $ranked_users = $stmt_rank->fetchAll(PDO::FETCH_ASSOC);

    // Calculer le rang de l'utilisateur connecté
    foreach ($ranked_users as $index => $user) {
        if ($user['id'] == $idusers) {
            $user_rank = $index + 1;
            break;
        }
    }
}
?>

<!DOCTYPE html>
<?php require_once (($_SERVER['DOCUMENT_ROOT'] . '/tulipe/headFoot/header.php')) ?>
<body background="/tulipe/img/wallpaper-tulipe.jpg">

<div class="ranking">
    <h1>Classement des Utilisateurs</h1>

    <table class="ranking-table">
        <thead>
            <tr>
                <th>Rang</th>
                <th>Utilisateur</th>
                <th>Montant total (€)</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $rank = 1;
            foreach ($users as $user) {
                // Si l'utilisateur est connecté, mettre en évidence son nom
                $highlight = (isset($_SESSION['groupe']) && $user['groupe'] === $_SESSION['groupe']) ? 'highlight' : '';
                echo "<tr class='$highlight'>
                        <td>{$rank}</td>
                        <td>{$user['groupe']}</td>
                        <td>{$user['total']}</td>
                    </tr>";
                $rank++;
            }
            ?>
        </tbody>
    </table>

    <?php if (isset($_SESSION['groupe'])): ?>
        <div class="user-rank">
            <p>Vous êtes actuellement classé <strong><?php echo $user_rank; ?></strong> sur <?php echo count($users); ?> utilisateurs.</p>
        </div>
    <?php else: ?>
        <div class="user-rank">
            <p>Connectez-vous pour voir votre classement personnel.</p>
        </div>
    <?php endif; ?>

</div>

</body>
</html>