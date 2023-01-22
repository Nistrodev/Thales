<?php
// Importer la base de données
include '../config.php';

// Vérifie si l'utilisateur à la permission de voir la page
if (!(check_permission($conn, 'delete_roles'))) {
   // L'utilisateur n'a pas la permission, redirigez-le vers une autre page
   $_SESSION['message-failed'] = "Vous n'avez pas la permission de voir cette page.";
   header("Location: admin.php");
   exit;
 }

// Récupérer l'ID du rôle à partir de la requête GET
$role_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Si aucun ID de rôle n'a été spécifié, rediriger l'utilisateur vers la page de gestion des rôles
if (!$role_id) {
   header("Location: gestion-roles.php");
   exit;
}

// Récupérer les informations sur le rôle à partir de la base de données
$sql = "SELECT * FROM roles WHERE id = $role_id";
$result = mysqli_query($conn, $sql);
$role = mysqli_fetch_assoc($result);

// Si le rôle n'a pas été trouvé, rediriger l'utilisateur vers la page de gestion des rôles
if (!$role) {
   header("Location: gestion-roles.php");
   exit;
}

// Ne pas permettre la suppression des rôles "admin" et "user"
if ($role['name'] == 'admin' || $role['name'] == 'user') {
   // Rediriger l'utilisateur vers la page de gestion des rôles
   header("Location: gestion-roles.php");
   exit;
}

// Si le formulaire a été soumis
if (isset($_POST['submit'])) {
   // Supprimer le rôle de la base de données
   $sql = "DELETE FROM roles WHERE id = $role_id";
   mysqli_query($conn, $sql);

   // Ajoute un message de réussite
   $_SESSION['message-success'] = "Le rôle a été supprimé avec succès.";

   // Rediriger l'utilisateur vers la page de gestion des rôles
   header("Location: gestion-roles.php");
   exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Thales - Supprimer un rôle</title>
</head>
<body>

   <!-- Sidebar -->
   <?php include "navbar-admin.php"; ?>

   <!-- Contenu principal -->
   <div class="container mt-4">

      <!-- Contenu de la page -->
      <h1>Supprimer un rôle</h1>

      <p>Êtes-vous sûr de vouloir supprimer le rôle <strong><?php echo $role["name"]; ?></strong> ?</p>

      <form action="supprimer-roles.php?id=<?php echo $role_id; ?>" method="post">
      <button type="submit" name="submit" class="btn btn-danger">Oui</button>
         <a href="gestion-roles.php" class="btn btn-secondary">Non</a>
      </form>

   </div>

</body>
</html>
