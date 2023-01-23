<?php
// Importer la base de donnée
include '../config.php';
// Vérifie si l'utilisateur à la permission de voir la page
if (!(check_permission($conn, 'manage_subcategories'))) {
   // L'utilisateur n'a pas la permission, redirigez-le vers une autre page
   $_SESSION['message-failed'] = NO_PERMISSIONS;
   header("Location: admin.php");
   exit;
}
if (isset($_GET["search"])) {
   $search = mysqli_real_escape_string($conn, $_GET["search"]);
   $sql = "SELECT sc.id, c.name AS parent_name, sc.name FROM subcategories sc INNER JOIN categories c ON sc.parent_id=c.id WHERE sc.name LIKE '%$search%'";
   $result = mysqli_query($conn, $sql);
} else {
   // Si aucune recherche n'a été effectuée, sélectionne toutes les catégories
   $sql = "SELECT sc.id, c.name AS parent_name, sc.name FROM subcategories sc INNER JOIN categories c ON sc.parent_id=c.id";
   $result = mysqli_query($conn, $sql);
}
// Récupérer les données de toutes les sous-catégories
$subcategories = mysqli_fetch_all($result, MYSQLI_ASSOC);

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
   <title>Thales - <?php echo SUBCATEGORIES_MANAGE_TITLE?></title>
</head>

<body>

   <!-- Sidebar -->
   <?php include "navbar-admin.php"; ?>

   <!-- Contenu principal -->
   <div class="container mt-4">

      <!-- Contenu de la page -->
      <form action="gestion-sous-categories.php" method="get" class="form-inline my-2 my-lg-0">
         <input name="search" class="form-control mr-sm-2" type="search" placeholder="Recherche" aria-label="Search">
         <button class="btn btn-outline-success my-2 my-sm-20" type="submit"><?php echo SEARCH?></button>
      </form>

      <!-- Tableau -->
      <?php if (!empty($subcategories)) { ?>
         <table class="table table-striped table-bordered">
            <thead>
               <tr>
                  <th><?php echo SUBCATEGORIES_MANAGE_ID?></th>
                  <th><?php echo SUBCATEGORIES_MANAGE_NAME?></th>
                  <th><?php echo SUBCATEGORIES_MANAGE_PARENT?></th>
                  <?php if ((check_permission($conn, 'modify_subcategories')) or (check_permission($conn, 'delete_subcategories'))) { ?>
                     <th><?php echo SUBCATEGORIES_MANAGE_ACTIONS?></th>
                  <?php } ?>
               </tr>
            </thead>
            <tbody>
               <!-- Boucle sur les résultats de la requête -->
               <?php foreach ($subcategories as $subcategory) {
               ?>
                  <tr>
                     <td> <?php echo $subcategory['id'] ?></td>
                     <td> <?php echo $subcategory['name'] ?></td>
                     <td> <?php echo $subcategory['parent_name']; ?></td>
                     <?php if ((check_permission($conn, 'modify_subcategories')) or (check_permission($conn, 'delete_subcategories'))) { ?>
                        <td>
                           <!-- Boutons d'action -->
                           <?php if ((check_permission($conn, 'view_articles'))) { ?>
                              <a href="gestion-articles-sous-categories.php?id=<?php echo $subcategory['id']; ?>" class="btn btn-primary">Voir les articles</a>
                           <?php }
                           if ((check_permission($conn, 'modify_subcategories'))) { ?>
                              <a href="modifier-sous-categories.php?id=<?php echo $subcategory["id"]; ?>" class="btn btn-warning">Modifier</a>
                           <?php }
                           if ((check_permission($conn, 'delete_subcategories'))) { ?>
                              <a href="supprimer-sous-categories.php?id=<?php echo $subcategory["id"]; ?>" class="btn btn-danger">Supprimer</a>
                           <?php } ?>
                        </td>
                     <?php } ?>
                  </tr>
               <?php } ?>
            </tbody>
         </table>
      <?php } else { ?>
         <div class="alert alert-warning" role="alert"><?php echo SUBCATEGORIES_MANAGE_NO_SUBCATEGORIES?></div>
      <?php } ?>

      <!-- Barre de pagination -->
      <!-- Div qui contiendra le menu de sélection du nombre de résultats par page -->
      <div class="float-right">
         <?php if ((check_permission($conn, 'create_subcategories'))) { ?>
            <a href="creer-sous-categories.php" class="btn btn-success"><?php echo SUBCATEGORIES_MANAGE_CREATE?></a>
         <?php } ?>

      </div>
      <nav aria-label="Page navigation example">
         <ul class="pagination">
            <!-- Bouton Précédent -->
            <li class="page-item <?php if ($page == 1) echo "disabled"; ?>">
               <a class="page-link" href="gestion-sous-categories.php?page=<?php echo $page - 1; ?>&limit=<?php echo $limit; ?>"><?php echo PREVIOUS?></a>
            </li>
            <!-- Boutons des pages -->
            <?php for ($i = 1; $i <= $numPages; $i++) { ?>
               <li class="page-item <?php if ($page == $i) echo "active"; ?>"><a class="page-link" href="gestion-sous-categories.php?page=<?php echo $i; ?>&limit=<?php echo $limit; ?>"><?php echo $i; ?></a></li>
            <?php
            } ?>
            <!-- Bouton Suivant -->
            <li class="page-item <?php if ($page == $numPages) echo "disabled"; ?>">
               <a class="page-link" href="gestion-sous-categories.php?page=<?php echo $page + 1; ?>&limit=<?php echo $limit; ?>"><?php echo NEXT?></a>
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
      <div class="alert alert-danger alert-dismissible position-fixed mr-2 float-right" style="bottom: 10px; right: 20px;">
         <?php echo $_SESSION['message-failed']; ?>
         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
         </button>
      </div>
      <?php $_SESSION['message-failed'] = null; ?>
<?php }
} ?>