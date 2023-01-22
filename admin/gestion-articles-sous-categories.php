<?php
require_once "../config.php";

// Récupération de l'ID de la sous-catégorie depuis l'URL
$subcategory_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Si aucun ID de sous catégories n'a été spécifié, rediriger l'utilisateur vers la page de gestion des articles
if (!$subcategory_id) {
    header("Location: gestion-articles.php");
    exit;
 }


// Requête pour récupérer les articles de la sous-catégorie
$sql = "SELECT * FROM articles WHERE subcategory_id = $subcategory_id";
$result = mysqli_query($conn, $sql);
$articles = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Requête pour récupérer le nom de la sous-catégorie
$sql = "SELECT name FROM subcategories WHERE id = $subcategory_id";
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
    <title>Articles de la sous-catégorie <?php echo $subcategory_name; ?></title>
</head>

<body>
    <!-- Sidebar -->
    <?php include "navbar-admin.php"; ?>

    <!-- Contenu principal -->
    <div class="container mt-4">

        <!-- Titre -->
        <h1>Articles de la sous-catégorie <?php echo $subcategory_name; ?></h1>

        <!-- Tableau -->
        <?php if(!empty($articles)) { ?>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Description</th>
                    <th>Prix</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($articles as $article) : ?>
                    <tr>
                        <td><?php echo $article['id']; ?></td>
                        <td><?php echo $article['name']; ?></td>
                        <td><?php echo $article['description']; ?></td>
                        <td><?php echo $article['price']; ?></td>
                        <?php if ($article['image'] == null) { ?>
                            <td>Aucune image</td>
                        <?php } else { ?>
                            <td><img src="<?php echo $article['image']; ?>" alt="<?php echo $article['name']; ?>" style="width: 100px;"></td>
                        <?php } ?>
                        <td>
                            <a href="../article.php?id=<?php echo $article['id']; ?>" class="btn btn-primary">Voir</a>
                            <a href="modifier-article.php?id=<?php echo $article['id']; ?>" class="btn btn-warning">Modifier</a>
                            <a href="supprimer-article.php?id=<?php echo $article['id']; ?>" class="btn btn-danger">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php } else { ?>
         <div class="alert alert-warning" role="alert">
            Il n'y a aucun articles pour cette catégorie.
         </div>
      <?php } ?>

        <!-- Barre de pagination -->
        <!-- Div qui contiendra le menu de sélection du nombre de résultats par page -->
        <div>
            <div class="float-right">
                <?php if ((check_permission($conn, 'create_articles'))) { ?>
                    <a href="creer-articles.php" class="btn btn-success">Créer un article</a>
                <?php } ?>
            </div>
            <div class="float-left">
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <!-- Bouton Précédent -->
                        <li class="page-item <?php if ($page == 1) echo "disabled"; ?>">
                            <a class="page-link" href="gestion-articles.php?page=<?php echo $page - 1; ?>&limit=<?php echo $limit; ?>">Précédent</a>
                        </li>
                        <!-- Boutons des pages -->
                        <?php for ($i = 1; $i <= $numPages; $i++) { ?>
                            <li class="page-item <?php if ($page == $i) echo "active"; ?>"><a class="page-link" href="gestion-articles.php?page=<?php echo $i; ?>&limit=<?php echo $limit; ?>"><?php echo $i; ?></a></li>
                            <?php
                        } ?>
                        <!-- Bouton Suivant -->
                        <li class="page-item <?php if ($page == $numPages) echo "disabled"; ?>">
                            <a class="page-link" href="gestion-articles.php?page=<?php echo $page + 1; ?>&limit=<?php echo $limit; ?>">Suivant</a>
                        </li>
                    </ul>
                </nav>
            </div>
            <div style="text-align: center;">
                <a href="gestion-articles.php" class="btn btn-secondary">Retour</a>
            </div>
        </div>
    </div>
</body>

</html>