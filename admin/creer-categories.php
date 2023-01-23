<?php
// Importer la base de données
include '../config.php';

// Vérifie si l'utilisateur à la permission de voir la page
if (!(check_permission($conn, 'create_categories'))) {
   // L'utilisateur n'a pas la permission, redirigez-le vers une autre page
   $_SESSION['message-failed'] = NO_PERMISSIONS;
   header("Location: admin.php");
   exit;
 }

$sql = "SELECT id, name FROM categories";
$result = mysqli_query($conn, $sql);
$categories = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Si le formulaire a été soumis
if (isset($_POST['submit'])) {
   // Récupérer les données du formulaire
   $name = mysqli_real_escape_string($conn, $_POST['name']);

   $sql = "INSERT INTO categories (name) VALUES ('$name')";
    // Créer la catégorie
    mysqli_query($conn, $sql);

   $_SESSION['message-success'] = CATEGORIES_CREATE_SUCCESS;

    // Rediriger l'utilisateur vers la page de gestion des catégories
    header("Location: gestion-categories.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Thales - <?php echo CATEGORIES_CREATE_TITLE?></title>
</head>
<body>
   <!-- Barre de navigation -->
   <?php include "navbar-admin.php"; ?>
   <!-- Contenu principal -->
   <div class="container mt-4">
      <!-- Contenu de la page -->
      <h1><?php echo CATEGORIES_CREATE_TITLE?></h1>
      <!-- Formulaire de création de catégorie -->
      <form action="creer-categories.php" method="post">
         <!-- Nom de la catégorie -->
         <div class="form-group">
            <label for="name"><?php echo CATEGORIES_CREATE_NAME?></label>
            <input type="text" class="form-control" name="name" id="name" required>
         </div>
         <!-- Bouton de soumission -->
         <a href="gestion-categories.php" class="btn btn-secondary"><?php echo RETOUR?></a>
         <button type="submit" name="submit" class="btn btn-primary"><?php echo CREER?></button>
      </form>
   </div>
</body>
</html>
