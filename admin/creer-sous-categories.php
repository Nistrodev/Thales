<?php
// Importer la base de données
include '../config.php';

// Vérifie si l'utilisateur à la permission de voir la page
if (!(check_permission($conn, 'create_subcategories'))) {
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
   $parent_id = mysqli_real_escape_string($conn, $_POST['parent_id']);

   // Vérifier que la catégorie parente existe
   $sql = "SELECT * FROM categories WHERE id='$parent_id' LIMIT 1";
   $result = mysqli_query($conn, $sql);
   $parent = mysqli_fetch_assoc($result);
   if (!$parent) {
      // La catégorie parente n'a pas été trouvée, afficher un message d'erreur
      $error_msg = SUBCATEGORIES_CREATE_NO_PARENT;
   } else {
      // Créer la sous-catégorie
      $sql = "INSERT INTO subcategories (name, parent_id) VALUES ('$name', '$parent_id')";
      mysqli_query($conn, $sql);

      $_SESSION['message-success'] = SUBCATEGORIES_CREATE_SUCCESS;

      // Rediriger l'utilisateur vers la page de gestion des catégories
      header("Location: gestion-sous-categories.php");
      exit;
   }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Thales - <?php echo SUBCATEGORIES_CREATE_TITLE?></title>
</head>
<body>
   <!-- Barre de navigation -->
   <?php include "navbar-admin.php"; ?>
   <!-- Contenu principal -->
   <div class="container mt-4">
      <!-- Contenu de la page -->
      <h1><?php echo SUBCATEGORIES_CREATE_TITLE?></h1>
      <?php if (empty($categories)) { ?>
         <div class="alert alert-warning" role="alert"><?php echo SUBCATEGORIES_CREATE_NO_CATEGORIES?></div>
         <a href="gestion-sous-categories.php" class="btn btn-secondary"><?php echo RETOUR?></a>
         <a href="gestion-categories.php" class="btn btn-success"><?php echo CREER?></a>
         <?php } else { ?>
      <!-- Formulaire de création de sous-catégorie -->
      <form action="creer-sous-categories.php" method="post">
         <!-- Nom de la sous-catégorie -->
         <div class="form-group">
            <label for="name"><?php echo SUBCATEGORIES_CREATE_NAME?></label>
            <input type="text" class="form-control" name="name" id="name" required>
         </div>
         <!-- Catégorie parente -->
         <div class="form-group">
            <label for="parent_id"><?php echo SUBCATEGORIES_CREATE_PARENT?></label>
            <select class="form-control" name="parent_id" id="parent_id" required>
               <!-- Liste des catégories -->
               <option value="" selected disabled hidden><?php echo SUBCATEGORIES_CREATE_SELECT_PARENT?></option>
               <?php foreach ($categories as $category): ?>
                  <option value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>
               <?php endforeach; ?>
            </select>
         </div>
         <!-- Bouton de soumission -->
         <a href="gestion-sous-categories.php" class="btn btn-secondary"><?php echo RETOUR?></a>
         <button type="submit" name="submit" class="btn btn-primary"><?php echo CREER?></button>
      </form>
      <?php } ?>
   </div>
</body>
</html>
