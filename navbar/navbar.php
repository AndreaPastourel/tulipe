<link href="tulipe/css/style.css" rel="stylesheet" />
<link href="tulipe/css/bootstrap.css" rel="stylesheet" />

<!-- header section starts -->
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
                            <a href="/tulipe/index.php">Classement</a>

                            <?php if (isset($_SESSION['username'])): ?>
                                <!-- Si l'utilisateur est connecté -->
                                <a href="#">Connecté(e) : <?php echo $_SESSION['username']; ?></a>
                                
                                <?php if ($_SESSION['role'] == 'Professeur'): ?>
                                    <a href="/tulipe/crud/user/crudUser.php">Consulter les élèves</a>
                                    <?php endif; ?>
                                    <a href="/tulipe/crud/tulipe/crudTulipe.php">Bons de commandes</a>
                               
                                
                                <a href="/tulipe/logreg/logout.php">Déconnexion</a>
                            <?php else: ?>
                                <!-- Si l'utilisateur n'est pas connecté -->
                                <a href="/tulipe/logreg/login.php">Connexion</a>
                            <?php endif; ?>

                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </div>
</header>
<!-- end header section -->


<!-- jQuery -->
<script src="/tulipe/js/jquery-3.4.1.min.js"></script>
<!-- bootstrap js -->
<script src="/tulipe/js/bootstrap.js"></script>
<!-- lightbox Gallery-->
<script src="/tulipe/js/ekko-lightbox.min.js"></script>
<!-- custom js -->
<script src="/tulipe/js/custom.js"></script>
