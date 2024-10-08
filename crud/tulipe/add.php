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
    $prix = $_POST['prix'];
    $moyen_de_paiement = $_POST['moyen_de_paiement'];
    $est_paye = isset($_POST['est_paye']) ? 1 : 0;
    $idusers = $_SESSION['id']; // ID de l'utilisateur courant
    $signature = $_POST['signature'];

    // Insertion dans la base de données
    $stmt = $pdo->prepare("INSERT INTO tulipes (quantite, prix, moyen_de_paiement, est_paye, idusers, signature) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$quantite, $prix, $moyen_de_paiement, $est_paye, $idusers, $signature]);

    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>


<body background="/tulipe/img/wallpaper-tulipe.jpg">

    <div class="form">
        <h1>Ajouter une Tulipe</h1>

        <p><a href="/tulipe/crud/user/crudUser.php">Retour en arrière</a></p>

        <!-- Début du formulaire -->
        <form action="add.php" method="post" enctype="multipart/form-data">
            <table>
                <tr>
                    <td>Quantité</td>
                    <td><input type="number" name="quantite" required></td>
                </tr>
                <tr>
                    <td>Prix</td>
                    <td><input type="text" name="prix" required></td>
                </tr>
                <tr>
                    <td>Moyen de paiement</td>
                    <td><input type="text" name="moyen_de_paiement" required></td>
                </tr>
                <tr>
                    <td>Est payé</td>
                    <td><input type="checkbox" name="est_paye"></td>
                </tr>
                <tr>
                    <td>Signature</td>
                    <td>
                        <canvas id="signature-pad" class="signature-pad"></canvas><br>
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

    <!-- footer section -->
    <?php require_once($_SERVER['DOCUMENT_ROOT'] . '/arrasGames/headFoot/footer.php'); ?>
    <!-- footer section -->

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
            const dataURL = canvas.toDataURL(); // Convertir le dessin en image
            signatureInput.value = dataURL; // Stocker dans un input caché
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
</html>
