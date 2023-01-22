<?php
// Inclusion du fichier config.php
require_once "config.php";
// Récupération des catégories et sous-catégories
$categories_query = "SELECT * FROM categories";
$categories_result = mysqli_query($conn, $categories_query);
$categories = mysqli_fetch_all($categories_result, MYSQLI_ASSOC);

$subcategories_query = "SELECT * FROM subcategories";
$subcategories_result = mysqli_query($conn, $subcategories_query);
$subcategories = mysqli_fetch_all($subcategories_result, MYSQLI_ASSOC);

if (!$categories_result || !$subcategories_result) {
  echo "Erreur MySQL : " . mysqli_error($conn);
}
?>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="/"><img src="images/Logo.png" alt="Logo" style="width: 75px;"></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav mr-auto">
    <!-- Afficher les catégories -->
    <?php foreach ($categories as $category) { ?>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <?php echo $category['name']; ?>
        </a>
        <?php $has_subcategories = false; ?>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <!-- Afficher les sous-catégories de la catégorie en cours -->
          <?php foreach ($subcategories as $subcategory) { ?>
            <?php if ($subcategory['parent_id'] == $category['id']) { ?>
              <a class="dropdown-item" href="/categorie/<?php echo $subcategory['id']; ?>"><?php echo $subcategory['name']; ?></a>
              <?php $has_subcategories = true; ?>
            <?php }; ?>
          <?php }; ?>
          <?php if (!$has_subcategories) : ?>
            <!-- Afficher un message si aucune sous-catégorie n'est trouvée -->
            <a class="dropdown-item disabled" href="#">Aucune sous-catégorie trouvée</a>
          <?php endif; ?>
        </div>
      </li>
    <?php }; ?>
  </ul>
    <ul class="navbar-nav">
      <?php if (is_logged()) : ?>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?php echo get_username(); ?>
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown" style="left: -125px;">
            <?php
            // Récupération du nombre de crédits de l'utilisateur
            $username = get_username();
            $sql = "SELECT * FROM users WHERE username = '$username'";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) == 1) {
              $row = mysqli_fetch_assoc($result);
              $credits = $row['credits'];
            }
            ?>
            <a class="dropdown-item disabled" href="#"><?php echo $credits; ?> crédits</a>
            <a class="dropdown-item" href="profil-utilisateurs.php?id=<?php echo $row["id"]; ?>">Mon profil</a>
            <a class="dropdown-item" href="/reservations">Mes réservations</a>
            <?php
            // Vérifier si l'utilisateur a la permission de voir le panel d'administration
            if ((check_permission($conn, 'view_admin_panel'))) {
            ?>
              <a class="dropdown-item" href="admin/admin.php">Panel d'administrateur</a>
            <?php
            }
            ?>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="logout.php">Déconnexion</a>
          </div>
        </li>
      <?php else : ?>
        <li class="nav-item">
          <a class="btn btn-primary" href="login.php">Se connecter</a>
        </li>
      <?php endif; ?>
    </ul>


  </div>
</nav>