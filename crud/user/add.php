<?php 
   // if (session_status() == PHP_SESSION_NONE) {
    //session_start();}
    //if(!isset($_SESSION['username']) || $_SESSION['role']!="Professeur"){
      //header("Location: /tulipe/unauthorized.php");
        //exit();
    //}
    ?>

<?php require_once (($_SERVER['DOCUMENT_ROOT'] . '/tulipe/headFoot/header.php'))?>


<body background="/tulipe/img/wallpaper-tulipe.jpg">

    <div class="crud">
    <h1>Ajouter des données</h1>
    <?php echo isset($messageValide) ? "<span style='color:green;'>$messageValide</span>" : '';?>
    <?php echo isset($messageErreur) ? "<span style='color:red;'>$messageErreur</span>" : '';?>

        <p><a href="/tulipe/crud/user/crudUser.php">Retour en arriere</a></p>

        <form action="/tulipe/crud/user/action/add.php" method="post" name="add" enctype="multipart/form-data">
    <table>
        <tr>
            <td>Groupe</td>
            <td><input type="text" name="groupe" required></td>
        </tr>
        <tr>
            <td>Login</td>
            <td><input type="text" name="login" required></td>
        </tr>
        <tr>
            <td>Email</td>
            <td><input type="text" name="email" required></td>
        </tr>

        <tr>
                <td>Password</td>
                <td>
                    <div >
                    <input type="password" name="password" id="password" required>
                    <i class="far fa-eye" id="togglePassword" style="cursor: pointer;"></i>
                    </div>
                </td>
                <?php echo isset($erreurPassword) ? "<span style='color:red;'>$erreurPassword</span>" : '';?>
                </tr>

        <tr>
            <td>Role</td>
            <td>
                <select name="role" id="role" required>
                    <option value="">--Choisir une option-</option>
                    <option value="Professeur">Professeur</option>
                    <option value="Eleve">Eleve</option>
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