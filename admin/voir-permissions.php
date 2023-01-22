<?php
// Importer la base de donnée
include '../config.php';

// Vérifie si l'utilisateur à la permission de voir la page
if (!(check_permission($conn, 'view_roles_permissions'))) {
   // L'utilisateur n'a pas la permission, redirigez-le vers une autre page
   $_SESSION['message-failed'] = "Vous n'avez pas la permission de voir cette page.";
   header("Location: admin.php");
   exit;
 }

// Vérifier si l'ID du rôle a été envoyé en GET
if (!isset($_GET["id"])) {
   // L'ID n'a pas été envoyé, redirigez l'utilisateur vers la page "gestion-roles.php"
   header("Location: gestion-roles.php");
   exit;
} else {
   // Récupérez l'ID du rôle à partir de l'URL
   $role_id = intval($_GET['id']);
}


// Sélectionnez le rôle à partir de la base de données
$sql = "SELECT * FROM roles WHERE id = $role_id";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

// Récupérer la liste de toutes les permissions disponibles
$sql = "SELECT * FROM permissions";
$result = mysqli_query($conn, $sql);
$permissions = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Séparer les permissions du rôle en utilisant ";" comme délimiteur
$permissions_str = explode(';', $row['permissions']);

// Créer un tableau vide qui contiendra les noms des permissions
$permission_names = array();

// Boucler sur chaque permission
foreach ($permissions as $permission) {
   // Si la valeur de la permission est présente dans la chaîne des permissions du rôle
   if (in_array($permission['value'], $permissions_str)) {
      // Ajouter le nom de la permission au tableau
      $permission_names[] = $permission['name'];
   }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Thales - Permissions du rôle</title>
</head>
<body>

<!-- Sidebar -->
<?php include "navbar-admin.php"; ?>

<!-- Contenu principal -->
<div class="container mt-4">

   <!-- Contenu de la page -->
   <h2>Permissions du rôle <?php echo $row['name']; ?></h2>
   <?php if (empty($row['permissions'])) { ?>
    <div class="alert alert-warning" role="alert">
      Le role <?php echo $row['name']; ?> n'a aucune permission.
    </div>
   <?php } else { ?>
   <table class="table table-striped table-bordered">
      <thead>
         <tr>
            <th>Permission</th>
         </tr>
      </thead>
      <tbody>
         <!-- Boucle sur les noms des permissions -->
         <?php foreach ($permission_names as $name) { ?>
         <tr>
            <td><?php echo $name; ?></td>
         </tr>
         <?php } ?>
      </tbody>
   </table>
   <?php } ?>
   <a href="gestion-roles.php" class="btn btn-secondary">Retour</a>
</div>

</body>
</html>
