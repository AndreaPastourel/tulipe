<?php 
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . '/tulipe/conn/dbConnect.php');

// Requête SQL pour récupérer le classement par total d'argent accumulé par groupe
$stmt = $pdo->prepare("
    SELECT u.groupe, COALESCE(SUM(t.prix), 0) as total 
    FROM users u 
    LEFT JOIN tulipes t ON t.idusers = u.id
    GROUP BY u.groupe 
    ORDER BY total DESC
");
$stmt->execute();
$groups = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Si l'utilisateur est connecté, récupérer le rang de son groupe
$group_rank = null;  // Définir une valeur par défaut
if (isset($_SESSION['groupe'])) {
    $groupe = $_SESSION['groupe'];

    // Requête pour récupérer tous les groupes classés par total d'argent accumulé
    $stmt_rank = $pdo->prepare("
        SELECT u.groupe, COALESCE(SUM(t.prix), 0) as total 
        FROM users u 
        LEFT JOIN tulipes t ON t.idusers = u.id
        GROUP BY u.groupe 
        ORDER BY total DESC
    ");
    $stmt_rank->execute();
    $ranked_groups = $stmt_rank->fetchAll(PDO::FETCH_ASSOC);

    // Calculer le rang du groupe connecté
    foreach ($ranked_groups as $index => $group) {
        if ($group['groupe'] == $groupe) {
            $group_rank = $index + 1;
            break;
        }
    }
}
?>

<!DOCTYPE html>
<?php require_once (($_SERVER['DOCUMENT_ROOT'] . '/tulipe/headFoot/header.php')); ?>
<?php require_once (($_SERVER['DOCUMENT_ROOT'] . '/tulipe/navbar/navbar.php')); ?>
<body background="/tulipe/img/wallpaper-tulipe.jpg">

<div class="ranking">
    <h1>Classement des Groupes</h1>

    <table class="ranking-table">
        <thead>
            <tr>
                <th>Rang</th>
                <th>Groupe</th>
                <th>Montant total (€)</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $rank = 1;
            foreach ($groups as $group) {
                // Si l'utilisateur est connecté, mettre en évidence son groupe
                $highlight = (isset($_SESSION['groupe']) && $group['groupe'] === $_SESSION['groupe']) ? 'highlight' : '';
                echo "<tr class='$highlight'>
                        <td>{$rank}</td>
                        <td>{$group['groupe']}</td>
                        <td>{$group['total']}</td>
                    </tr>";
                $rank++;
            }
            ?>
        </tbody>
    </table>

    <?php if (isset($_SESSION['groupe'])): ?>
        <div class="user-rank">
            <p>Votre groupe est actuellement classé <strong><?php echo $group_rank; ?></strong> sur <?php echo count($groups); ?> groupes.</p>
        </div>
    <?php else: ?>
        <div class="user-rank">
            <p>Connectez-vous pour voir le classement de votre groupe.</p>
        </div>
    <?php endif; ?>

</div>

</body>
</html>