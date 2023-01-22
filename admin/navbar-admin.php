<?php require_once "../config.php" ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/sidebar-admin.css">
  <script src="../js/sidebar-admin.js"></script>
</head>

<body id="body-pd">
  <header class="header" id="header">
    <div class="header_toggle">
      <i class='bx bx-menu' id="header-toggle"></i>
    </div>
  </header>
  <div class="l-navbar" id="nav-bar">
    <nav class="nav">
      <div>
        <a class="nav_logo">
          <i class='bx bx-user-circle nav_logo-icon'></i>
          <span class="nav_logo-name"><?php echo get_username(); ?></span>
        </a>

        <div class="nav_list">
          <a href="admin.php" class="nav_link">
            <i class='bx bx-grid-alt nav_icon'></i>
            <span class="nav_name">Accueil</span>
          </a>
          <?php if ((check_permission($conn, 'manage_images'))) { ?>
            <a href="gestion-images.php" class="nav_link">
              <i class='bx bx-images nav_icon'></i>
              <span class="nav_name">Gestion des images</span>
            </a>
          <?php }
          if ((check_permission($conn, 'manage_users'))) { ?>
            <a href="gestion-utilisateurs.php" class="nav_link">
              <i class='bx bx-user nav_icon'></i>
              <span class="nav_name">Gestion des utilisateurs</span>
            </a>
          <?php }
          if ((check_permission($conn, 'manage_roles'))) { ?>
            <a href="gestion-roles.php" class="nav_link">
              <i class='bx bx-bot nav_icon'></i>
              <span class="nav_name">Gestion des Rôles</span>
            </a>
          <?php }
          if ((check_permission($conn, 'manage_credits'))) { ?>
            <a href="gestion-credits.php" class="nav_link">
              <i class='bx bx-money nav_icon'></i>
              <span class="nav_name">Gestion des Crédits</span>
            </a>
          <?php }
          if ((check_permission($conn, 'manage_categories'))) { ?>
            <a href="gestion-categories.php" class="nav_link">
              <i class='bx bx-folder nav_icon'></i>
              <span class="nav_name">Gestion des Catégories</span>
            </a>
          <?php }
          if ((check_permission($conn, 'manage_subcategories'))) { ?>
            <a href="gestion-sous-categories.php" class="nav_link">
              <i class='bx bx-bar-chart-alt-2 nav_icon'></i>
              <span class="nav_name">Gestion des Sous-Catégories</span>
            </a>
          <?php }
          if ((check_permission($conn, 'manage_articles'))) { ?>
            <a href="gestion-articles.php" class="nav_link">
              <i class='bx bx-cart nav_icon'></i>
              <span class="nav_name">Gestion des articles</span>
            </a>
          <?php } ?>
        </div>
      </div>

      <a href="../index.php" class="nav_link">
        <i class='bx bx-log-out nav_icon'></i>
        <span class="nav_name">Retour au site</span>
      </a>
    </nav>
  </div>


</body>

</html>