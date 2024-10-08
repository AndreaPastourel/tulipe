<?php 
    if (session_status() == PHP_SESSION_NONE) {
   session_start();}
    if(!isset($_SESSION['username']) || $_SESSION['role']!="Professeur"){
     header("Location: /tulipe/unauthorized.php");
      exit();
    }
    ?>


<?php require_once (($_SERVER['DOCUMENT_ROOT'] . '/tulipe/headFoot/header.php'));
require_once (($_SERVER['DOCUMENT_ROOT'] . '/tulipe/navbar/navbar.php'));?>

<?php
//Include the database connection file
require_once(($_SERVER['DOCUMENT_ROOT'] . '/tulipe/conn/dbConnect.php'));

//Requete pour recuperer les utilisateurs 
$stmt=$pdo->query("SELECT * FROM users ORDER BY id");
?>

<!DOCTYPE html>
<html>

<body background="/tulipe/img/wallpaper-tulipe.jpg">
<div class='form'>
    <?php
    // Vérification de l'ID
    if (!isset($_GET['id']) || empty($_GET['id'])) {
        echo "Erreur : ID non spécifié.";
        exit();
    }

    $id = $_GET['id'];

    try {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE id=?");
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $login = $result['login'];
            $groupe = $result['groupe'];
            $password = $result['password'];  // hashed password
            $email = $result['email'];
            $role = $result['role'];
        } else {
            echo "Aucun utilisateur trouvé avec cet ID.";
            exit();
        }
    } catch (PDOException $e) {
        echo "ERREUR : " . $e->getMessage();
    }
    ?>

<h2>Modifier les informations</h2>
<p><a href="/tulipe/crud/user/crudUser.php">Retour en arrière</a></p>

<!-- Début Formulaire -->
<form action="/tulipe/crud/user/action/edit.php" method="post" name="add" enctype="multipart/form-data">
    <table>
        <tr>
            <td>Groupe</td>
            <td><input type="text" name="groupe" value="<?php echo $groupe; ?>"></td>
        </tr>
        <tr>
            <td>Login</td>
            <td><input type="text" name="login" value="<?php echo $login; ?>"></td>
        </tr>
        <tr>
            <td>Password</td>
            <td>
                <div class="password-container">
                    <input type="password" name="password" id="password" >
                    <i class="far fa-eye" id="togglePassword" style="cursor: pointer;"></i>
                </div>
            </td>
            <?php echo isset($erreurPassword) ? "<span style='color:red;'>$erreurPassword</span>" : ''; ?>
        </tr>
        <tr>
            <td>Email</td>
            <td><input type="email" name="email" value="<?php echo $email; ?>"></td>
        </tr>
        <tr>
            <td>Role</td>
            <td>
                <select name="role" id="role">
                    <option value="<?php echo $role; ?>"><?php echo $role; ?></option>
                    <option value="Professeur">Professeur</option>
                    <option value="Eleve">Eleve</option>
                   
                </select>
            </td>
        </tr>
        <tr>
            <td><input type="hidden" name="id" value="<?php echo $id; ?>"></td>
            <td><input type="submit" name="update" value="Modifier"></td>
        </tr>
    </table>
</form>
</div>

<script>
const togglePassword = document.querySelector('#togglePassword');
const password = document.querySelector('#password');

togglePassword.addEventListener('click', function(e) {
    // basculer le type d'input entre password et text
    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
    password.setAttribute('type', type);

    // changer l'icône selon l'état
    this.classList.toggle('fa-eye-slash');
});
</script>

</body>
</html>
