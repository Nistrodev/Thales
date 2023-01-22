<?php
// Importer la base de donnée
include '../config.php';
// Vérifie si l'utilisateur à la permission de voir la page
if (!(check_permission($conn, 'manage_articles'))) {
    // L'utilisateur n'a pas la permission, redirigez-le vers une autre page
    $_SESSION['message-failed'] = "Vous n'avez pas la permission de voir cette page.";
    header("Location: admin.php");
    exit;
}
if (isset($_GET["search"])) {
    $search = mysqli_real_escape_string($conn, $_GET["search"]);
    $sql = "SELECT * FROM subcategories WHERE name LIKE '%$search%'";
    $result = mysqli_query($conn, $sql);
} else {
    // Si aucune recherche n'a été effectuée, sélectionnez tous les utilisateurs
    $sql = "SELECT * FROM subcategories";
    $result = mysqli_query($conn, $sql);
}

$subcategories = mysqli_fetch_all($result, MYSQLI_ASSOC);
// Si aucun articles n'a été trouvée
if (mysqli_num_rows($result) == 0) {
    $art = false;
} else {
    $art = true;
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
    <title>Thales - Gestion des articles</title>
</head>

<body>

    <!-- Sidebar -->
    <?php include "navbar-admin.php"; ?>

    <!-- Contenu principal -->
    <div class="container mt-4">

        <!-- Contenu de la page -->
        <form action="gestion-articles.php" method="get" class="form-inline my-2 my-lg-0">
            <input name="search" class="form-control mr-sm-2" type="search" placeholder="Recherche" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-20" type="submit">Rechercher</button>
        </form>

        <!-- Tableau -->
        <?php if ($art) { ?>
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Sous-Catégorie</th>
                        <?php if ((check_permission($conn, 'view_articles')) or (check_permission($conn, 'manage_subcategories'))) { ?>
                            <th>Actions</th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>
                    <!-- Boucle sur les résultats de la requête -->
                    <?php foreach ($subcategories as $subcategory) { ?>
                        <tr>
                            <td><?php echo $subcategory['id']; ?></td>
                            <td><?php echo $subcategory['name']; ?></td>
                            <?php if ((check_permission($conn, 'view_articles')) or (check_permission($conn, 'manage_subcategories'))) { ?>
                                <td>
                                    <!-- Boutons d'action -->
                                    <?php if ((check_permission($conn, 'view_articles'))) { ?>
                                        <a href="gestion-articles-sous-categories.php?id=<?php echo $subcategory['id']; ?>" class="btn btn-primary">Voir les articles</a>
                                    <?php }
                                    if (check_permission($conn, 'manage_subcategories')) { ?>
                                        <a href="gestion-sous-categories.php?search=<?php echo $subcategory['name']; ?>" class="btn btn-dark">Voir la sous-catégorie</a>
                                    <?php } ?>
                                </td>
                            <?php } ?>
                        </tr>
                    <?php
                    } ?>
                </tbody>
            </table>
        <?php } else { ?>
            <div class="alert alert-warning" role="alert">
                Il n'y a aucun articles.
            </div>
        <?php } ?>

        <!-- Barre de pagination -->
        <!-- Div qui contiendra le menu de sélection du nombre de résultats par page -->
        <div class="float-right">
            <?php if ((check_permission($conn, 'create_articles'))) { ?>
                <a href="creer-articles.php" class="btn btn-success">Créer un article</a>
            <?php } ?>
        </div>
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <!-- Bouton Précédent -->
                <li class="page-item <?php if ($page == 1) echo "disabled"; ?>">
                    <a class="page-link" href="gestion-articles.php?page=<?php echo $page - 1; ?>&limit=<?php echo $limit; ?>">Précédent</a>
                </li>
                <!-- Boutons des pages -->
                <?php for ($i = 1; $i <= $numPages; $i++) { ?>
                    <li class="page-item <?php if ($page == $i) echo "active"; ?>"><a class="page-link" href="gestion-utilisateurs.php?page=<?php echo $i; ?>&limit=<?php echo $limit; ?>"><?php echo $i; ?></a></li>
                <?php
                } ?>
                <!-- Bouton Suivant -->
                <li class="page-item <?php if ($page == $numPages) echo "disabled"; ?>">
                    <a class="page-link" href="gestion-articles.php?page=<?php echo $page + 1; ?>&limit=<?php echo $limit; ?>">Suivant</a>
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