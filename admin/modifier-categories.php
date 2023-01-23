<?php
// Importer la base de données
include '../config.php';

// Vérifie si l'utilisateur à la permission de voir la page
if (!(check_permission($conn, 'modify_categories'))) {
   // L'utilisateur n'a pas la permission, redirigez-le vers une autre page
   $_SESSION['message-failed'] = NO_PERMISSIONS;
   header("Location: admin.php");
   exit;
 }

// Récupérer l'ID de la sous catégories à partir de la requête GET
$categories_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Si aucun ID de sous catégories n'a été spécifié, rediriger l'utilisateur vers la page de gestion des sous-catégories
if (!$categories_id) {
   $_SESSION['message-failed'] = NO_ID_SUBCATEGORIES;
   header("Location: gestion-categories.php");
   exit;
}

// Récupérer les informations sur la catégorie à partir de la base de données
$sql = "SELECT * FROM categories WHERE id = $categories_id";
$result = mysqli_query($conn, $sql);
$categories = mysqli_fetch_assoc($result);

// Si la catégorie n'a pas été trouvé, redirige l'utilisateur vers la page de gestion des sous catégories
if (!$categories) {
   $_SESSION['message-failed'] = NO_CATEGORIES;
    header("Location: gestion-categories.php");
    exit;
 }

// Si le formulaire a été soumis
if (isset($_POST['submit'])) {
   // Récupérer les données du formulaire
   $name = mysqli_real_escape_string($conn, $_POST['name']);

   // Mettre à jour les informations de la sous-catégorie dans la base de données
   if (!empty($name)) {
      $sql = "UPDATE categories SET name='$name' WHERE id=$categories_id";
   }
   mysqli_query($conn, $sql);

   // Affiche un message de succès
   $_SESSION['message-success'] = "La catégorie à été modifié avec succès.";

   // Rediriger l'utilisateur vers la page de gestion des sous-catégories
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
   <title>Thales - <?php echo CATEGORIE_MODIFY_TITLE?></title>
</head>
<body>
   <!-- Barre de navigation -->
   <?php include "navbar-admin.php"; ?>
   <!-- Contenu principal -->
   <div class="container mt-4">
      <!-- Contenu de la page -->
      <h1><?php echo CATEGORIE_MODIFY_TITLE?></h1>
      <!-- Formulaire de création de catégorie -->
      <form action="modifier-categories.php?id=<?php echo $categories_id; ?>" method="post">
         <!-- Nom de la catégorie -->
         <div class="form-group">
            <label for="name"><?php echo CATEGORIE_MODIFY_NAME?></label>
            <input type="text" class="form-control" name="name" id="name" value="<?php echo $categories['name']; ?>">
         </div>
         <!-- Bouton de soumission -->
         <a href="gestion-categories.php" class="btn btn-secondary"><?php echo RETOUR?></a>
         <button type="submit" name="submit" class="btn btn-primary"><?php echo MODIFY?></button>
      </form>
   </div>
</body>
</html>
