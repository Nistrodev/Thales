<?php
// Importer la base de donnée
include '../config.php';


// Vérifie si l'utilisateur à la permission de voir la page
if (!(check_permission($conn, 'manage_roles'))) {
   // L'utilisateur n'a pas la permission, redirigez-le vers une autre page
   $_SESSION['message-failed'] = "Vous n'avez pas la permission de voir cette page.";
   header("Location: admin.php");
   exit;
}
if (isset($_GET["search"])) {
   $search = mysqli_real_escape_string($conn, $_GET["search"]);
   $sql = "SELECT * FROM roles WHERE name LIKE '%$search%'";
   $result = mysqli_query($conn, $sql);
} else {
   // Si aucune recherche n'a été effectuée, sélectionnez tous les utilisateurs
   $sql = "SELECT * FROM roles";
   $result = mysqli_query($conn, $sql);
}

// Pagination
$page = isset($_GET["page"]) ? intval($_GET["page"]) : 1;
$limit = isset($_GET["limit"]) ? intval($_GET["limit"]) : 10;
$offset = ($page - 1) * $limit;
$totalRows = mysqli_num_rows($result);
$numPages = ceil($totalRows / $limit);

// Modifiez la requête pour prendre en compte la pagination
$sql = $sql . " LIMIT $limit OFFSET $offset";
$result = mysqli_query($conn, $sql);


?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Thales - Gestion des rôles</title>
</head>

<body>

   <!-- Sidebar -->
   <?php include "navbar-admin.php"; ?>

   <!-- Contenu principal -->
   <div class="container mt-4">

      <!-- Contenu de la page -->
      <form action="gestion-roles.php" method="get" class="form-inline my-2 my-lg-0">
         <input name="search" class="form-control mr-sm-2" type="search" placeholder="Recherche" aria-label="Search">
         <button class="btn btn-outline-success my-2 my-sm-20" type="submit">Rechercher</button>
      </form>

      <!-- Tableau -->
      <table class="table table-striped table-bordered">
         <thead>
            <tr>
               <th>ID</th>
               <th>Rôle</th>
               <th>Nombres d'utilisateurs</th>
               <?php if ((check_permission($conn, 'view_roles_permissions'))) { ?>
                  <th>Permissions</a></th>
               <?php } ?>
               <?php if ((check_permission($conn, 'modify_roles')) or (check_permission($conn, 'delete_roles'))) { ?>
                  <th>Actions</th>
               <?php } ?>
            </tr>
         </thead>
         <tbody>
            <!-- Boucle sur les résultats de la requête -->
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
               <tr>
                  <td><?php $role_id = $row["id"];
                        echo $row["id"]; ?></td>
                  <td><?php echo $row["name"]; ?></td>
                  <td><?php
                        $sql_nb_users = "SELECT COUNT(u.id) as nombre_utilisateurs
         FROM users u
         JOIN roles r ON u.role = r.name
         WHERE r.id = $role_id";
                        $result_nb_users = mysqli_query($conn, $sql_nb_users);
                        // Récupérez le nombre d'utilisateurs avec ce rôle
                        $row_nb_users = mysqli_fetch_assoc($result_nb_users);
                        $nombre_utilisateurs = $row_nb_users["nombre_utilisateurs"];
                        echo $nombre_utilisateurs; ?></td>
                  <?php if ((check_permission($conn, 'view_roles_permissions'))) { ?>
                     <td><a href="voir-permissions.php?id=<?php echo $row["id"]; ?>" class="btn btn-primary">Voir les permissions</a></td>
                  <?php } ?>
                  <?php if ((check_permission($conn, 'modify_roles')) or (check_permission($conn, 'delete_roles'))) { ?>
                     <td>
                        <!-- Boutons d'action -->
                        <?php if ((check_permission($conn, 'modify_roles'))) { ?>
                           <a href="modifier-roles.php?id=<?php echo $row["id"]; ?>" class="btn btn-warning">Modifier</a>
                        <?php } ?>
                        <?php if ($row['name'] == 'admin' || $row['name'] == 'user') { ?>
                        <?php } else { ?>
                           <?php if ((check_permission($conn, 'delete_roles'))) { ?>
                              <a href="supprimer-roles.php?id=<?php echo $row["id"]; ?>" class="btn btn-danger">Supprimer</a>
                           <?php } ?>
                        <?php } ?>
                     </td>
                  <?php } ?>
               </tr>
            <?php
            } ?>
         </tbody>
      </table>

      <!-- Barre de pagination -->
      <!-- Div qui contiendra le menu de sélection du nombre de résultats par page -->
      <div class="float-right">
         <?php if ((check_permission($conn, 'create_roles'))) { ?>
            <a href="creation-role.php" class="btn btn-success">Créer un rôle</a>
         <?php } ?>

      </div>
      <nav aria-label="Page navigation example">
         <ul class="pagination">
            <!-- Bouton Précédent -->
            <li class="page-item <?php if ($page == 1) echo "disabled"; ?>">
               <a class="page-link" href="gestion-roles.php?page=<?php echo $page - 1; ?>&limit=<?php echo $limit; ?>">Précédent</a>
            </li>
            <!-- Boutons des pages -->
            <?php for ($i = 1; $i <= $numPages; $i++) { ?>
               <li class="page-item <?php if ($page == $i) echo "active"; ?>"><a class="page-link" href="gestion-roles.php?page=<?php echo $i; ?>&limit=<?php echo $limit; ?>"><?php echo $i; ?></a></li>
            <?php
            } ?>
            <!-- Bouton Suivant -->
            <li class="page-item <?php if ($page == $numPages) echo "disabled"; ?>">
               <a class="page-link" href="gestion-roles.php?page=<?php echo $page + 1; ?>&limit=<?php echo $limit; ?>">Suivant</a>
            </li>
         </ul>
      </nav>
   </div>
   </div>
</body>

</html>

<!-- Message de notification -->
<?php if ((isset($_SESSION['message-success'])) || (isset($_SESSION['message-failed']))) {
   if (isset($_SESSION['message-success'])) { ?>
      <div class="alert alert-success alert-dismissible position-fixed mr-2 float-right" style="bottom: 10px; right: 20px;">
         <?php echo $_SESSION['message-success']; ?>
         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
         </button>
      </div>
      <?php $_SESSION['message-success'] = null; ?>
   <?php }
   if (isset($_SESSION['message-failed'])) {  ?>
      <div class="alert alert-failed alert-dismissible position-fixed mr-2 float-right" style="bottom: 10px; right: 20px;">
         <?php echo $_SESSION['message-failed']; ?>
         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
         </button>
      </div>
      <?php $_SESSION['message-failed'] = null; ?>
<?php }
} ?>