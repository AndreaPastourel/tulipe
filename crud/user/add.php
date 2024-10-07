<?php 
   // if (session_status() == PHP_SESSION_NONE) {
    //session_start();}
    //if(!isset($_SESSION['username']) || $_SESSION['role']!="admin"){
      //header("Location: ../../../unauthorized.php");
        //exit();
    //}
    ?>

<!DOCTYPE html>
<html>

<?php require_once  ($_SERVER['DOCUMENT_ROOT'] . '/arrasGames/headFoot/header.php')?>

<body background="/arrasGames/img/arrasGames-bg-2.jpg">
<?php require_once ($_SERVER['DOCUMENT_ROOT'] . '/arrasGames/headFoot/nav.php')?>
<div class="formulaire">


        <h2>Ajouter des données </h2>
        <p><a href="/arrasGames/crudUsers.php">Retour en arriere</a></p>

        <form action="action/add.php" method="post" name="add" enctype="multipart/form-data">
    <table>
        <tr>
            <td>Username</td>
            <td><input type="text" name="username" required></td>
        </tr>

        <tr>
                <td>Password</td>
                <td>
                    <div class="password-container">
                    <input type="password" name="password" id="password" required>
                    <i class="far fa-eye" id="togglePassword" style="cursor: pointer;"></i>
                    </div>
                </td>
                <?php echo isset($erreurPassword) ? "<span style='color:red;'>$erreurPassword</span>" : '';?>
                </tr>

        <tr>
            <td>Email</td>
            <td><input type="email" name="email" required></td>
        </tr>

        <tr>
            <td>Role</td>
            <td>
                <select name="role" id="role" required>
                    <option value="">--Please choose an option--</option>
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                    <option value="staff">Staff</option>
                </select>
            </td>
        </tr>

        <tr>
            <td><input type="submit" name="submit" value="Ajouter"></td>
        </tr>
    </table>
</form>


    </div>
    </div>

  <!-- footer section -->
  <?php require_once($_SERVER['DOCUMENT_ROOT'] . '/arrasGames/headFoot/footer.php'); ?>
  <!-- footer section -->
   
<script>
  const togglePassword = document.querySelector('#togglePassword');
  const password = document.querySelector('#password');

  togglePassword.addEventListener('click', function (e) {
    // basculer le type d'input entre password et text
    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
    password.setAttribute('type', type);
    
    // changer l'icône selon l'état
    this.classList.toggle('fa-eye-slash');
  });
</script>
    
</body>
</html>