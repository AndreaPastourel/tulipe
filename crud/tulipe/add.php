<?php 
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . '/tulipe/conn/dbConnect.php');
require_once (($_SERVER['DOCUMENT_ROOT'] . '/tulipe/headFoot/header.php'));

// Vérifier que l'utilisateur est connecté
if (!isset($_SESSION['username'])) {
    header("Location: /tulipe/login.php");
    exit();
}

if (isset($_POST['submit'])) {
    $quantite = $_POST['quantite'];
    $moyen_de_paiement = $_POST['moyen_de_paiement'];
    $est_paye = isset($_POST['est_paye']) ? 1 : 0;
    $idusers = $_SESSION['id']; // ID de l'utilisateur courant
    $signature = $_POST['signature']; // Récupérer la signature en base64

    // Vérifier si une signature a été fournie
    if (!empty($signature)) {
        // Convertir la signature base64 en un fichier image
        $signature = str_replace('data:image/png;base64,', '', $signature);
        $signature = str_replace(' ', '+', $signature);
        $data = base64_decode($signature);
        $file_name = 'signature_' . time() . '.png'; // Nom du fichier unique
        $file_path = $_SERVER['DOCUMENT_ROOT'] . '/tulipe/uploads/' . $file_name;

        // Sauvegarder l'image dans le dossier uploads
        file_put_contents($file_path, $data);
    } else {
        $file_name = null; // Si pas de signature
    }

    // Insertion dans la base de données
    try {
        $stmt = $pdo->prepare("INSERT INTO tulipes (quantite, moyen_de_paiement, est_paye, idusers, signature) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$quantite, $moyen_de_paiement, $est_paye, $idusers, $file_name]);
        $messageValide = "La commande a bien été ajoutée avec succès.";
    } catch (PDOException $e) {
        $messageErreur = "ERREUR: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>

<body background="/tulipe/img/wallpaper-tulipe.jpg">

    <div class="form">
        <h1>Ajouter une Tulipe</h1>

        <p><a href="/tulipe/crud/tulipe/crudTulipe.php">Retour en arrière</a></p>

        <!-- Affichage des messages de succès ou d'erreur -->
        <?php 
        if (isset($messageValide)) {
            echo "<span style='color:green;'>$messageValide</span>";
        }
        if (isset($messageErreur)) {
            echo "<span style='color:red;'>$messageErreur</span>";
        }
        ?>

        <!-- Début du formulaire -->
        <form action="add.php" method="post" enctype="multipart/form-data">
            <table>
                <tr>
                    <td>Quantité</td>
                    <td><input type="number" name="quantite" required></td>
                </tr>
              
                <tr>
                    <td>Moyen de paiement</td>
                    <td>
                        <select name="moyen_de_paiement" id="role" required>
                            <option value="">--Choisir une option--</option>
                            <option value="espece">Espèce</option>
                            <option value="cheque">Chèque</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Est payé</td>
                    <td><input type="checkbox" name="est_paye"></td>
                </tr>
                <tr>
                    <td>Signature</td>
                    <td>
                        <canvas id="signature-pad" class="signature-pad" style="border: 1px solid #000;"></canvas><br>
                        <button type="button" id="clear-btn">Effacer</button>
                        <input type="hidden" id="signature" name="signature">
                    </td>
                </tr>
                <tr>
                    <td><input type="submit" name="submit" value="Ajouter"></td>
                </tr>
            </table>
        </form>
        <!-- Fin du formulaire -->

    </div>

    <script>
        const canvas = document.getElementById('signature-pad');
        const clearButton = document.getElementById('clear-btn');
        const signatureInput = document.getElementById('signature');
        const context = canvas.getContext('2d');

        let drawing = false;

        // Redimensionner le canvas
        canvas.width = canvas.offsetWidth;
        canvas.height = 200;

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

        // Bouton pour effacer le canvas
        clearButton.addEventListener('click', function () {
            context.clearRect(0, 0, canvas.width, canvas.height);
            signatureInput.value = ''; // Réinitialiser l'input caché
        });
    </script>

</body>

</html>