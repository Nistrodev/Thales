<?php
require_once "../config.php";

// Vérifie si l'utilisateur à la permission de voir la page
if (!(check_permission($conn, 'manage_articles'))) {
    // L'utilisateur n'a pas la permission, redirigez-le vers une autre page
    $_SESSION['message-failed'] = NO_PERMISSIONS;
    header("Location: admin.php");
    exit;
}

// Récupération de l'ID de la sous-catégorie depuis l'URL
$subcategory_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Si aucun ID de sous catégories n'a été spécifié, rediriger l'utilisateur vers la page de gestion des articles
if (!$subcategory_id) {
    $_SESSION['message-failed'] = NO_ID_SUBCATEGORIES;
    header("Location: gestion-articles.php");
    exit;
}


// Requête pour récupérer les articles de la sous-catégorie
$sql = "SELECT * FROM articles WHERE subcategory_id = $subcategory_id";
$result = mysqli_query($conn, $sql);
$articles = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Requête pour récupérer le nom de la sous-catégorie
$sql = "SELECT * FROM subcategories WHERE id = $subcategory_id";
$result = mysqli_query($conn, $sql);
$subcategory_name = mysqli_fetch_assoc($result)['name'];

// Pagination
$page = isset($_GET["page"]) ? intval($_GET["page"]) : 1;
$limit = isset($_GET["limit"]) ? intval($_GET["limit"]) : 10;
$offset = ($page - 1) * $limit;
$totalRows = mysqli_num_rows($result);
$numPages = ceil($totalRows / $limit);

// Modifiez la requête pour prendre en compte la pagination
$sql = $sql . " LIMIT $limit OFFSET $offset";
$result = mysqli_query($conn, $sql);

// Si aucune catégorie n'a été trouvée
if (mysqli_num_rows($result) == 0) {
    $cat = false;
} else {
    $cat = true;
}

?>

<!DOCTYPE html>
<html>

<head>
    <title><?php echo ARTICLE_SUBCATEGORIES_MANAGE_TITLE?> <?php echo $subcategory_name; ?></title>
</head>

<body>
    <!-- Sidebar -->
    <?php include "navbar-admin.php"; ?>

    <!-- Contenu principal -->
    <div class="container mt-4">

        <!-- Titre -->
        <h1><?php echo ARTICLE_SUBCATEGORIES_MANAGE_TITLE?> <?php echo $subcategory_name; ?></h1>

        <!-- Tableau -->
        <?php if (!empty($articles)) { ?>
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th><?php echo ARTICLE_SUBCATEGORIES_MANAGE_ID?></th>
                        <th><?php echo ARTICLE_SUBCATEGORIES_MANAGE_NAME?></th>
                        <th><?php echo ARTICLE_SUBCATEGORIES_MANAGE_DESCRIPTION?></th>
                        <th><?php echo ARTICLE_SUBCATEGORIES_MANAGE_PRICE?></th>
                        <th><?php echo ARTICLE_SUBCATEGORIES_MANAGE_IMAGE?></th>
                        <th><?php echo ARTICLE_SUBCATEGORIES_MANAGE_ACTIONS?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($articles as $article) { ?>
                        <tr>
                            <td><?php echo $article['id']; ?></td>
                            <td><?php echo $article['name']; ?></td>
                            <td><?php echo $article['description']; ?></td>
                            <td><?php echo $article['price']; ?></td>
                            <?php if ($article['image'] == null) { ?>
                                <td><?php echo ARTICLE_SUBCATEGORIES_MANAGE_NO_IMAGES?></td>
                            <?php } else { ?>
                                <td><img src="<?php echo $article['image']; ?>" alt="<?php echo $article['name']; ?>" style="width: 100px;"></td>
                            <?php } ?>
                            <td>
                                <a href="../article.php?id=<?php echo $article['id']; ?>" class="btn btn-primary"><?php echo VIEWS?></a>
                                <a href="modifier-article.php?id=<?php echo $article['id']; ?>" class="btn btn-warning"><?php echo MODIFY?></a>
                                <a href="supprimer-article.php?id=<?php echo $article['id']; ?>" class="btn btn-danger"><?php echo DELETE?></a>
                            </td>
                        </tr>
                    <?php }; ?>
                </tbody>
            </table>
        <?php } else { ?>
            <div class="alert alert-warning" role="alert"><?php echo ARTICLE_SUBCATEGORIES_MANAGE_NO_ARTICLES?></div>
        <?php } ?>

        <!-- Barre de pagination -->
        <!-- Div qui contiendra le menu de sélection du nombre de résultats par page -->
        <div>
            <div class="float-right">
                <?php if ((check_permission($conn, 'create_articles'))) { ?>
                    <a href="creer-articles.php?subcategory_id=<?php echo $subcategory_id; ?>" class="btn btn-success"><?php echo ARTICLE_SUBCATEGORIES_MANAGE_CREATE_ARTICLE?></a>
                <?php } ?>
            </div>
            <div class="float-left">
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <!-- Bouton Précédent -->
                        <li class="page-item <?php if ($page == 1) echo "disabled"; ?>">
                            <a class="page-link" href="gestion-articles.php?page=<?php echo $page - 1; ?>&limit=<?php echo $limit; ?>"><?php echo PREVIOUS?></a>
                        </li>
                        <!-- Boutons des pages -->
                        <?php for ($i = 1; $i <= $numPages; $i++) { ?>
                            <li class="page-item <?php if ($page == $i) echo "active"; ?>"><a class="page-link" href="gestion-articles-sous-categories.php?page=<?php echo $i; ?>&limit=<?php echo $limit; ?>"><?php echo $i; ?></a></li>
                        <?php
                        } ?>
                        <!-- Bouton Suivant -->
                        <li class="page-item <?php if ($page == $numPages) echo "disabled"; ?>">
                            <a class="page-link" href="gestion-articles.php?page=<?php echo $page + 1; ?>&limit=<?php echo $limit; ?>"><?php echo NEXT?></a>
                        </li>
                    </ul>
                </nav>
            </div>
            <div style="text-align: center;">
                <a href="gestion-articles.php" class="btn btn-secondary"><?php echo RETOUR?></a>
            </div>
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