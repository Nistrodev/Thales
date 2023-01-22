<?php
// Importer la base de donnée
include '../config.php';
// Vérifie si l'utilisateur à la permission de voir la page
if (!(check_permission($conn, 'manage_users'))) {
   // L'utilisateur n'a pas la permission, redirigez-le vers une autre page
   $_SESSION['message-failed'] = "Vous n'avez pas la permission de voir cette page.";
   header("Location: admin.php");
   exit;
 }
if (isset($_GET["search"]))
{
    $search = mysqli_real_escape_string($conn, $_GET["search"]);
    $sql = "SELECT * FROM users WHERE username LIKE '%$search%'";
    $result = mysqli_query($conn, $sql);
}
else
{
    // Si aucune recherche n'a été effectuée, sélectionnez tous les utilisateurs
    $sql = "SELECT * FROM users";
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
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Thales - Gestion des utilisateurs</title>
</head>
<body>
    
  <!-- Sidebar -->
  <?php include "navbar-admin.php"; ?>

  <!-- Contenu principal -->
<div class="container mt-4">

<!-- Contenu de la page -->
<form action="gestion-utilisateurs.php" method="get" class="form-inline my-2 my-lg-0">
   <input name="search" class="form-control mr-sm-2" type="search" placeholder="Recherche" aria-label="Search">
   <button class="btn btn-outline-success my-2 my-sm-20" type="submit">Rechercher</button>
</form>

<!-- Tableau -->
<table class="table table-striped table-bordered">
   <thead>
      <tr>
         <th><a>Id</a></th>
         <th><a>Username</a></th>
         <th>Email</a></th>
         <th>Crédits</a></th>
         <th>Rôle</a></th>
         <?php if ((check_permission($conn, 'modify_users')) OR (check_permission($conn, 'delete_users'))) { ?>
         <th>Actions</th>
         <?php } ?>
      </tr>
   </thead>
   <tbody>
      <!-- Boucle sur les résultats de la requête -->
      <?php while ($row = mysqli_fetch_assoc($result))
   { ?>
      <tr>
         <td><?php echo $row["id"]; ?></td>
         <td><?php echo $row["username"]; ?></td>
         <td><?php echo $row["email"]; ?></td>
         <td><?php echo $row["credits"]; ?></td>
         <td><?php echo $row["role"]; ?></td>
         <?php if ((check_permission($conn, 'modify_users')) OR (check_permission($conn, 'delete_users'))) { ?>
         <td>
            <!-- Boutons d'action -->
            <?php if ((check_permission($conn, 'modify_users'))) { ?>
            <a href="modifier-utilisateur.php?id=<?php echo $row["id"]; ?>" class="btn btn-warning">Modifier</a>
            <?php } if (!($row['username'] == 'admin')) { ?>
               <?php if ((check_permission($conn, 'delete_users'))) { ?>
            <a href="supprimer-utilisateur.php?id=<?php echo $row["id"]; ?>" class="btn btn-danger">Supprimer</a>
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
   <?php if ((check_permission($conn, 'create_users'))) { ?>
   <a href="creer-utilisateur.php" class="btn btn-success">Créer un utilisateur</a>
   <?php } ?>
</div>
   <nav aria-label="Page navigation example">
      <ul class="pagination">
         <!-- Bouton Précédent -->
         <li class="page-item <?php if ($page == 1) echo "disabled"; ?>">
            <a class="page-link" href="gestion-utilisateurs.php?page=<?php echo $page-1; ?>&limit=<?php echo $limit; ?>">Précédent</a>
         </li>
         <!-- Boutons des pages -->
         <?php for ($i=1; $i<=$numPages; $i++)
   { ?>
         <li class="page-item <?php if ($page == $i) echo "active"; ?>"><a class="page-link" href="gestion-utilisateurs.php?page=<?php echo $i; ?>&limit=<?php echo $limit; ?>"><?php echo $i; ?></a></li>
         <?php
   } ?>
         <!-- Bouton Suivant -->
         <li class="page-item <?php if ($page == $numPages) echo "disabled"; ?>">
            <a class="page-link" href="gestion-utilisateurs.php?page=<?php echo $page+1; ?>&limit=<?php echo $limit; ?>">Suivant</a>
         </li>
      </ul>
   </nav>
</div>
</div>

<!-- Message de notification -->
<?php if ((isset($_SESSION['message-success'])) || (isset($_SESSION['message-failed']))) {
    if (isset($_SESSION['message-success'])) { ?>
        <div class="alert alert-success alert-dismissible fixed-bottom mr-5" role="alert">
            <?php echo $_SESSION['message-success']; ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <?php $_SESSION['message-success'] = null; ?>
    <?php }; ?>
<?php }; ?>
</body>
</html>