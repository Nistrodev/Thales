<?php
// Importer la base de données
include '../config.php';

// Vérifie si l'utilisateur à la permission de voir la page
if (!(check_permission($conn, 'modify_subcategories'))) {
   // L'utilisateur n'a pas la permission, redirigez-le vers une autre page
   $_SESSION['message-failed'] = "Vous n'avez pas la permission de voir cette page.";
   header("Location: admin.php");
   exit;
}

// Récupérer l'ID de la sous catégories à partir de la requête GET
$subcategories_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Si aucun ID de sous catégories n'a été spécifié, rediriger l'utilisateur vers la page de gestion des sous-catégories
if (!$subcategories_id) {
   header("Location: gestion-categories.php");
   exit;
}

// Récupérer les informations sur l'utilisateur à partir de la base de données
$sql = "SELECT * FROM subcategories WHERE id = $subcategories_id";
$result = mysqli_query($conn, $sql);
$subcategories = mysqli_fetch_assoc($result);

$sql = "SELECT id, name FROM categories";
$result = mysqli_query($conn, $sql);
$categories = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Si la sous catégorie n'a pas été trouvé, redirige l'utilisateur vers la page de gestion des sous catégories
if (!$subcategories) {
   header("Location: gestion-sous-categories.php");
   exit;
}

// Si le formulaire a été soumis
if (isset($_POST['submit'])) {
   // Récupérer les données du formulaire
   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $parent_id = mysqli_real_escape_string($conn, $_POST['parent_id']);

   // Mettre à jour les informations de la sous-catégorie dans la base de données
   if (empty($parent_id)) {
      $sql = "UPDATE subcategories SET name='$name' WHERE id=$subcategories_id";
   } else {
      $sql = "UPDATE subcategories SET name='$name', parent_id='$parent_id' WHERE id=$subcategories_id";
   }
   mysqli_query($conn, $sql);

   // Affiche un message de succès
   $_SESSION['message-success'] = "La catégorie à été modifié avec succès.";

   // Rediriger l'utilisateur vers la page de gestion des sous-catégories
   header("Location: gestion-sous-categories.php");
   exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Thales - Modification sous-catégorie</title>
</head>

<body>
   <!-- Barre de navigation -->
   <?php include "navbar-admin.php"; ?>
   <!-- Contenu principal -->
   <div class="container mt-4">
      <!-- Contenu de la page -->
      <h1>Modification de la sous-catégorie</h1>
      <!-- Formulaire de création de sous-catégorie -->
      <form action="modifier-sous-categories.php?id=<?php echo $subcategories_id; ?>" method="post">
         <!-- Nom de la sous-catégorie -->
         <div class="form-group">
            <label for="name">Nom</label>
            <input type="text" class="form-control" name="name" id="name" value="<?php echo $subcategories['name']; ?>">
         </div>
         <!-- Catégorie parente -->
         <div class="form-group">
            <label for="parent_id">Catégorie parente</label>
            <select class="form-control" id="parent_id" name="parent_id">
               <option value="" selected disabled hidden>Choisissez une catégorie</option>
               <?php foreach ($categories as $category) { ?>
                  <option value="<?php echo $category['id']; ?>" <?php echo $subcategories['parent_id'] === $category['id'] ? 'selected' : ''; ?>>
                     <?php echo $category['name']; ?>
                  </option>
               <?php } ?>
            </select>
         </div>
         <!-- Bouton de soumission -->
         <a href="gestion-sous-categories.php" class="btn btn-secondary">Retour</a>
         <button type="submit" name="submit" class="btn btn-primary">Modifier</button>
      </form>
   </div>
</body>

</html>