
<link href="tulipe/css/style.css" rel="stylesheet" />

<link href="tulipe/css/bootstrap.css" rel="stylesheet" />

  
  
  
  <!-- header section strats -->
  <header class="header_section">
    <div class="container-fluid">
      <nav class="navbar navbar-expand-lg custom_nav-container">
        <div class="" id="">

        <div class="custom_menu-btn">
  <button onclick="openNav()">
    <span class="s-1"> </span>
    <span class="s-2"> </span>
    <span class="s-3"> </span>
  </button>
  <div id="myNav" class="overlay">
    <div class="overlay-content">
      <a href="index.php">Accueil</a>
      <?php if (isset($_SESSION['username'])): ?>
        <a href="#">Connecté(e)</a>
        <a href="tulipe">Consulter les élèves</a>
        <a href="reglog/logout.php">Déconnexion</a>
        <?php if ($_SESSION['role'] == 'Professeur'): ?>
          <a href="tulipe/crud/user/crudUser.php">Consulter les élèves</a>
          <?php else():  ?>
            <a href="tulipe/logreg/login.php">Connexion</a>
          <?php endif; ?>
      <?php endif; ?> <!-- Ajout de endif ici -->
    </div>
  </div>
</div>
</nav>
</div>
</header>

  <!-- end header section -->

  <!-- jQery -->
  <script src="/tulipe/js/jquery-3.4.1.min.js"></script>
  <!-- bootstrap js -->
  <script src="/tulipe/js/bootstrap.js"></script>
  <!-- lightbox Gallery-->
  <script src="/tulipe/js/ekko-lightbox.min.js"></script>
  <!-- custom js -->
  <script src="/tulipe/js/custom.js"></script>