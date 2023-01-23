<?php
// Importer la base de donnée
include '../config.php';

// Vérifie si l'utilisateur à la permission de voir la page
if (!(check_permission($conn, 'create_roles'))) {
   // L'utilisateur n'a pas la permission, redirigez-le vers une autre page
   $_SESSION['message-failed'] = NO_PERMISSIONS;
   header("Location: admin.php");
   exit;
}

// Récupérer la liste de toutes les permissions disponibles
$sql = "SELECT * FROM permissions";
$result = mysqli_query($conn, $sql);
$permissions = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Si le formulaire a été soumis
if (isset($_POST['submit'])) {
   // Récupérer les données du formulaire
   $name = mysqli_real_escape_string($conn, $_POST['role-name']);
   $selected_permissions = isset($_POST['permissions']) ? $_POST['permissions'] : array();

   // Convertir les permissions sélectionnées en une chaîne séparée par des points-virgules
   $permissions_str = implode(';', $selected_permissions);

   // Ajouter le rôle à la base de données
   $sql = "INSERT INTO roles (name, permissions) VALUES ('$name', '$permissions_str')";
   mysqli_query($conn, $sql);

   // Affiche un message de succès
   $_SESSION['message-success'] = ROLE_CREATE_SUCCESS;

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
   <title>Thales - <?php echo ROLE_CREATE_TITLE?></title>
</head>

<body>
   <!-- Sidebar -->
   <?php include "navbar-admin.php"; ?>
   <!-- Contenu principal -->
   <div class="container mt-4">
      <!-- Contenu de la page -->
      <h1><?php echo ROLE_CREATE_TITLE?></h1>
      <!-- Formulaire de création de rôle -->
      <form action="creation-role.php" method="post">
         <!-- Champ nom du rôle -->
         <div class="form-group">
            <label for="role-name"><?php echo ROLE_CREATE_NAME?></label>
            <input type="text" class="form-control" name="role-name" id="role-name" required>
         </div>
         <!-- Liste de permissions -->
         <div class="form-group">
            <label for="permissions"><?php echo ROLE_CREATE_PERMISSION?></label><br>
            <!-- Récupérer les permissions disponibles depuis la base de données -->
            <?php
            $permissions = get_permissions($conn);
            // Pour chaque permission
            foreach ($permissions as $permission) {
               // Afficher un checkbox avec le nom de la permission en tant que label
               echo "<div class='form-check'>";
               echo "<input class='form-check-input' type='checkbox' id='{$permission['value']}' name='permissions[]' value='{$permission['value']}' disabled>";
               echo "<label class='form-check-label' for='{$permission['value']}'> {$permission['name']} </label><br>";
               echo "</div>";
            }
            ?>
         </div>
         <!-- Bouton de soumission -->
         <a href="gestion-roles.php" class="btn btn-secondary"><?php echo RETOUR?></a>
         <button type="submit" name="submit" class="btn btn-primary"><?php echo CREER?></button>
      </form>
   </div>
   <script>
      $('#view_admin_panel').attr('disabled', false);
      $('#view_admin_panel').change(function() {
         // Si la permission est cochée
         if ($(this).is(':checked')) {
            // Activer la permission
            $('#manage_users').attr('disabled', false);
            $('#manage_users').change(function() {
               // Si la permission est cochée
               if ($(this).is(':checked')) {
                  $('#modify_users').attr('disabled', false);
                  $('#delete_users').attr('disabled', false);
                  $('#create_users').attr('disabled', false);
               } else {
                  $('#modify_users').attr('disabled', true);
                  $('#delete_users').attr('disabled', true);
                  $('#create_users').attr('disabled', true);
                  $('#modify_users').prop('checked', false);
                  $('#delete_users').prop('checked', false);
                  $('#create_users').prop('checked', false);
               }
            });
            $('#manage_roles').attr('disabled', false);
            $('#manage_roles').change(function() {
               // Si la permission est cochée
               if ($(this).is(':checked')) {
                  $('#view_roles_permissions').attr('disabled', false);
                  $('#modify_roles').attr('disabled', false);
                  $('#delete_roles').attr('disabled', false);
                  $('#create_roles').attr('disabled', false);
               } else {
                  $('#view_roles_permissions').attr('disabled', true);
                  $('#modify_roles').attr('disabled', true);
                  $('#delete_roles').attr('disabled', true);
                  $('#create_roles').attr('disabled', true);
                  $('#view_roles_permissions').prop('checked', false);
                  $('#modify_roles').prop('checked', false);
                  $('#delete_roles').prop('checked', false);
                  $('#create_roles').prop('checked', false);
               }
            })
            $('#manage_credits').attr('disabled', false);
            $('#manage_credits').change(function() {
               // Si la permission est cochée
               if ($(this).is(':checked')) {
                  $('#add_credits').attr('disabled', false);
                  $('#delete_credits').attr('disabled', false);
               } else {
                  $('#add_credits').attr('disabled', true);
                  $('#delete_credits').attr('disabled', true);
                  $('#add_credits').prop('checked', false);
                  $('#delete_credits').prop('checked', false);
               }
            })
            $('#manage_categories').attr('disabled', false);
            $('#manage_categories').change(function() {
               // Si la permission est cochée
               if ($(this).is(':checked')) {
                  $('#modify_categories').attr('disabled', false);
                  $('#delete_categories').attr('disabled', false);
                  $('#create_categories').attr('disabled', false);
               } else {
                  $('#modify_categories').attr('disabled', true);
                  $('#delete_categories').attr('disabled', true);
                  $('#create_categories').attr('disabled', true);
                  $('#modify_categories').prop('checked', false);
                  $('#delete_categories').prop('checked', false);
                  $('#create_categories').prop('checked', false);
               }
            })
            $('#manage_subcategories').attr('disabled', false);
            $('#manage_subcategories').change(function() {
               if ($(this).is(':checked')) {
                  $('#modify_subcategories').attr('disabled', false);
                  $('#delete_subcategories').attr('disabled', false);
                  $('#create_subcategories').attr('disabled', false);
               } else {
                  $('#modify_subcategories').attr('disabled', true);
                  $('#delete_subcategories').attr('disabled', true);
                  $('#create_subcategories').attr('disabled', true);
                  $('#modify_subcategories').prop('checked', false);
                  $('#delete_subcategories').prop('checked', false);
                  $('#create_subcategories').prop('checked', false);
               }
            });
         } else {
            // Désactiver la permission
            $('#manage_users').attr('disabled', true);
            $('#modify_users').attr('disabled', true);
            $('#delete_users').attr('disabled', true);
            $('#create_users').attr('disabled', true);
            $('#manage_roles').attr('disabled', true);
            $('#view_roles_permissions').attr('disabled', true);
            $('#modify_roles').attr('disabled', true);
            $('#delete_roles').attr('disabled', true);
            $('#create_roles').attr('disabled', true);
            $('#manage_credits').attr('disabled', true);
            $('#add_credits').attr('disabled', true);
            $('#delete_credits').attr('disabled', true);
            $('#manage_categories').attr('disabled', true);
            $('#modify_categories').attr('disabled', true);
            $('#delete_categories').attr('disabled', true);
            $('#create_categories').attr('disabled', true);
            $('#manage_subcategories').attr('disabled', true);
            $('#modify_subcategories').attr('disabled', true);
            $('#delete_subcategories').attr('disabled', true);
            $('#create_subcategories').attr('disabled', true);
            $('#manage_users').prop('checked', false);
            $('#modify_users').prop('checked', false);
            $('#delete_users').prop('checked', false);
            $('#create_users').prop('checked', false);
            $('#manage_roles').prop('checked', false);
            $('#view_roles_permissions').prop('checked', false);
            $('#modify_roles').prop('checked', false);
            $('#delete_roles').prop('checked', false);
            $('#create_roles').prop('checked', false);
            $('#manage_credits').prop('checked', false);
            $('#add_credits').prop('checked', false);
            $('#delete_credits').prop('checked', false);
            $('#manage_categories').prop('checked', false);
            $('#modify_categories').prop('checked', false);
            $('#delete_categories').prop('checked', false);
            $('#create_categories').prop('checked', false);
            $('#manage_subcategories').prop('checked', false);
            $('#modify_subcategories').prop('checked', false);
            $('#delete_subcategories').prop('checked', false);
            $('#create_subcategories').prop('checked', false);
         }
      });
   </script>
</body>

</html>