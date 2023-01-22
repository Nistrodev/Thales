<?php
// Importer la base de donnée
include '../config.php';

// Vérifie si l'utilisateur à la permission de voir la page
if (!(check_permission($conn, 'modify_roles'))) {
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

// Récupérer la liste de toutes les permissions disponibles
$sql = "SELECT * FROM permissions";
$result = mysqli_query($conn, $sql);
$permissions = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Convertir la chaîne de permissions du rôle en un tableau
$role_permissions = explode(';', $role['permissions']);

// Si le formulaire a été soumis
if (isset($_POST['submit'])) {
   // Récupérer les données du formulaire
   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $selected_permissions = isset($_POST['permissions']) ? $_POST['permissions'] : array();

   // Convertir les permissions sélectionnées en une chaîne séparée par des points-virgules
   $permissions_str = implode(';', $selected_permissions);

   // Mettre à jour les données du rôle dans la base de données
   if (empty($name)) {
      $sql = "UPDATE roles SET permissions = '$permissions_str' WHERE id = $role_id";
   } else {
      $sql = "UPDATE roles SET name = '$name', permissions = '$permissions_str' WHERE id = $role_id";
   }
   mysqli_query($conn, $sql);

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
   <title>Thales - Modifier un rôle</title>
</head>
<body>
<!-- Sidebar -->
<?php include "navbar-admin.php"; ?>
<!-- Contenu principal -->
<div class="container mt-4">
   <!-- Contenu de la page -->
   <h1>Modifier un rôle</h1>
   <!-- Formulaire de modification de rôle -->
   <form action="modifier-roles.php?id=<?php echo $role_id; ?>" method="post">
      <!-- Champ nom du rôle -->
      <div class="form-group">
         <label for="role-name">Nom du rôle</label>
         <?php if ($role['name'] == 'admin' || $role['name'] == 'user') { ?>
            <input type="text" class="form-control" name="role-name" id="role-name" value="<?php echo $role['name']; ?>" disabled>
         <?php } else { ?>
            <input type="text" class="form-control" name="role-name" id="role-name" value="<?php echo $role['name']; ?>" required>
         <?php }?>
      </div>
      <!-- Liste de permissions -->
      <div class="form-group">
         <label for="permissions">Permissions</label><br>
         <!-- Récupérer les permissions disponibles depuis la base de données -->
         <?php
            $permissions = get_permissions($conn);
            // Pour chaque permission
            foreach ($permissions as $permission) {
               // Vérifier si la permission est associée au rôle
               $checked = in_array($permission['value'], $role_permissions) ? "checked" : "";
               // Afficher un checkbox avec le nom de la permission en tant que label
               echo "<div class='form-check'>";
               echo "<input type='checkbox' class='form-check-input' name='permissions[]' value='" . $permission['value'] . "' " . $checked . ">";
               echo "<label class='form-check-label'>" . $permission['name'] . "</label>";
               echo "</div>";
            }
         ?>
      </div>
      <!-- Bouton de soumission -->
      <a href="gestion-roles.php" class="btn btn-secondary">Retour</a>
      <button type="submit" name="submit" class="btn btn-primary">Modifier le rôle</button>
   </form>
</div>
</body>
</html>