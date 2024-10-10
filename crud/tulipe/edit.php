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
        $adresse = $_POST['adresse'];  // Nouvelle adresse
        $client = $_POST['client'];    // Nom du client
        $semaines = isset($_POST['semaines']) ? $_POST['semaines'] : []; // Sélection des semaines
        $moyen_de_paiement = $_POST['moyen_de_paiement'];
        $telephone = isset($_POST['telephone']) ? $_POST['telephone'] : null;
        $est_paye = isset($_POST['est_paye']) ? 1 : 0;
        $remarque = $_POST['remarque'];
        $uploads_dir = $_SERVER['DOCUMENT_ROOT'] . '/tulipe/uploads/';  // Dossier de stockage des signatures

        // Gestion de la signature dessinée
        $signature = $_POST['signature'];  // Signature sous forme de base64

        // Si la signature est modifiée (si le champ n'est pas vide)
        if (!empty($signature)) {
            // Supprimer l'ancienne signature s'il y en a une
            if (!empty($res['signature']) && file_exists($uploads_dir . $res['signature'])) {
            }

            // Générer un nom de fichier unique pour la nouvelle signature
            $signature_filename = 'signature_' . time() . '.png';

            // Extraire les données de l'image base64
            $signature = str_replace('data:image/png;base64,', '', $signature);
            $signature = str_replace(' ', '+', $signature);
            $signature_data = base64_decode($signature);

            // Enregistrer la nouvelle signature dans le dossier uploads
            file_put_contents($uploads_dir . $signature_filename, $signature_data);
        } else {
            // Si la signature n'est pas modifiée, garder l'ancienne
            $signature_filename = $res['signature'];
        }

        // Conversion du tableau des semaines en JSON pour la base de données
        $semaines_json = json_encode($semaines);

        // Calcul automatique du prix (ajustez cette logique selon vos besoins)
        $prix = $quantite * 10;  // Exemple : chaque tulipe coûte 10€

        // Mise à jour de la tulipe avec les nouveaux champs
        $stmt = $pdo->prepare("UPDATE tulipes SET remarque=?, telephone=?,quantite = ?, adresse = ?, client = ?, semaines = ?, moyen_de_paiement = ?, est_paye = ?, signature = ? WHERE id = ?");
        $stmt->execute([$remarque,$telephone,$quantite, $adresse, $client, $semaines_json, $moyen_de_paiement, $est_paye, $signature_filename, $id]);

        header("Location:/tulipe/crud/tulipe/crudTulipe.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
    
<?php require_once (($_SERVER['DOCUMENT_ROOT'] . '/tulipe/headFoot/header.php'))?>
<?php require_once ($_SERVER['DOCUMENT_ROOT'] . '/tulipe/navbar/navbar.php');?>
<head>
    <title>Modifier la Tulipe</title>
    <style>
        .signature-pad {
            border: 1px solid #ccc;
            width: 300px;
            height: 150px;
            cursor: crosshair;
        }
    </style>
</head>
<body background="/tulipe/img/wallpaper-tulipe.jpg">
<div class='form'>
    <h2>Modifier la Tulipe</h2>
    <form method="post" action="edit.php?id=<?php echo $id; ?>" enctype="multipart/form-data">
        <table>
            <tr>
                <td><label>Client:</label></td>
                <td><input type="text" name="client" value="<?php echo htmlspecialchars($res['client']); ?>" required></td>
            </tr>
            <tr>
                <td><label>Adresse:</label></td>
                <td><input type="text" name="adresse" value="<?php echo htmlspecialchars($res['adresse']); ?>" required></td>
            </tr>
            <tr>
                <td><label>Quantité:</label></td>
                <td><input type="number" name="quantite" value="<?php echo htmlspecialchars($res['quantite']); ?>" required></td>
            </tr>
            <tr>
                <td><label>Semaines:</label></td>
                <td>
                    <?php 
                    $semaines = isset($res['semaines']) ? json_decode($res['semaines'], true) : [];
                    ?>
                    <input type="checkbox" name="semaines[]" value="1" <?php echo in_array('1', $semaines) ? 'checked' : ''; ?>> Semaine 1<br>
                    <input type="checkbox" name="semaines[]" value="2" <?php echo in_array('2', $semaines) ? 'checked' : ''; ?>> Semaine 2<br>
                    <input type="checkbox" name="semaines[]" value="3" <?php echo in_array('3', $semaines) ? 'checked' : ''; ?>> Semaine 3
                </td>
            </tr>
            <td>Moyen de Paiment</td>
            <td>
                <select name="moyen_de_paiement" id="moyen_de_paiement">
                    <option value="<?php echo $res['moyen_de_paiement']; ?>"><?php echo $res['moyen_de_paiement']; ?></option>
                    <option value="cheque">Cheque</option>
                    <option value="espece">Espece</option>
                    <option value="carte">Carte</option>
                </select>
            </td>
            <tr>
                <td><label>Est payé:</label></td>
                <td><input type="checkbox" name="est_paye" <?php if ($res['est_paye']) echo 'checked'; ?>></td>
            </tr>
            <tr>
                <td><label>Telephone:</label></td>
                <td><input type="text" name="telephone" value="<?php echo htmlspecialchars($res['telephone']); ?>" required></td>
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
                <td><label>Changer la signature (dessiner) :</label></td>
                <td>
                    <canvas id="signature-pad" class="signature-pad"></canvas><br>
                    <button type="button" id="clear-btn">Effacer</button>
                    <input type="hidden" name="signature" id="signature">
                </td>
            </tr>
            <tr>
                <td>Remarque</td>
                <td><textarea name="remarque" rows="4" cols="50"><?php echo htmlspecialchars($res['remarque']); ?></textarea></td>
            </tr>
            <tr>
                <td colspan="2" style="text-align:center;">
                    <input type="submit" name="submit" value="Mettre à jour">
                </td>
            </tr>
        </table>
    </form>
</div>

<script>
    const canvas = document.getElementById('signature-pad');
    const clearButton = document.getElementById('clear-btn');
    const signatureInput = document.getElementById('signature');
    const context = canvas.getContext('2d');

    let drawing = false;

    // Redimensionner le canvas
    canvas.width = canvas.offsetWidth;
    canvas.height = 150;

    canvas.addEventListener('mousedown', startDrawing);
    canvas.addEventListener('mouseup', stopDrawing);
    canvas.addEventListener('mousemove', draw);

    function startDrawing(event) {
        drawing = true;
        context.beginPath();
        context.moveTo(event.offsetX, event.offsetY);
    }

    function stopDrawing() {
        drawing = false;
        const dataURL = canvas.toDataURL('image/png'); // Convertir le dessin en image PNG
        signatureInput.value = dataURL; // Stocker dans l'input caché
    }

    function draw(event) {
        if (!drawing) return;
        context.lineTo(event.offsetX, event.offsetY);
        context.stroke();
    }

    // Effacer le dessin
    clearButton.addEventListener('click', function () {
        context.clearRect(0, 0, canvas.width, canvas.height);
        signatureInput.value = ''; // Réinitialiser l'input caché
    });
</script>

</body>
</html>