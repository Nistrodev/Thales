<?php
// Importer la base de données
include '../config.php';

// Vérifie si l'utilisateur à la permission de voir la page
if (!(check_permission($conn, 'create_subcategories'))) {
   // L'utilisateur n'a pas la permission, redirigez-le vers une autre page
   $_SESSION['message-failed'] = "Vous n'avez pas la permission de voir cette page.";
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
      $error_msg = "La catégorie parente avec l'identifiant '$parent_id' n'a pas été trouvée.";
   } else {
      // Créer la sous-catégorie
      $sql = "INSERT INTO subcategories (name, parent_id) VALUES ('$name', '$parent_id')";
      mysqli_query($conn, $sql);

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
   <title>Thales - Création de sous-catégorie</title>
</head>
<body>
   <!-- Barre de navigation -->
   <?php include "navbar-admin.php"; ?>
   <!-- Contenu principal -->
   <div class="container mt-4">
      <!-- Contenu de la page -->
      <h1>Création de sous-catégorie</h1>
      <?php if (empty($categories)) { ?>
         <div class="alert alert-warning" role="alert">
            Il n'y a aucune   catégorie disponible pour créer une sous-catégorie.
         </div>
         <a href="gestion-sous-categories.php" class="btn btn-secondary">Retour</a>
         <a href="gestion-categories.php" class="btn btn-success">Créer une catégorie</a>
         <?php } else { ?>
      <!-- Formulaire de création de sous-catégorie -->
      <form action="creer-sous-categories.php" method="post">
         <!-- Nom de la sous-catégorie -->
         <div class="form-group">
            <label for="name">Nom</label>
            <input type="text" class="form-control" name="name" id="name" required>
         </div>
         <!-- Catégorie parente -->
         <div class="form-group">
            <label for="parent_id">Catégorie parente</label>
            <select class="form-control" name="parent_id" id="parent_id" required>
               <!-- Liste des catégories -->
               <option value="" selected disabled hidden>Choissisez une catégorie parente</option>
               <?php foreach ($categories as $category): ?>
                  <option value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>
               <?php endforeach; ?>
            </select>
         </div>
         <!-- Bouton de soumission -->
         <a href="gestion-sous-categories.php" class="btn btn-secondary">Retour</a>
         <button type="submit" name="submit" class="btn btn-primary">Créer</button>
      </form>
      <?php } ?>
   </div>
</body>
</html>
