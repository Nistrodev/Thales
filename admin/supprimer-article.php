<?php
// Importer la base de données
include '../config.php';

// Vérifie si l'utilisateur à la permission de voir la page
if (!(check_permission($conn, 'delete_articles'))) {
    // L'utilisateur n'a pas la permission, redirigez-le vers une autre page
    $_SESSION['message-failed'] = NO_PERMISSIONS;
    header("Location: admin.php");
    exit;
}

// Récupérer l'ID de l'article à partir de la requête GET
$article_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Si aucun ID d'article n'a été spécifié, rediriger l'utilisateur vers la page de gestion des articles
if (!$article_id) {
    $_SESSION['message-failed'] = NO_ID_ARTICLES;
    header("Location: gestion-articles.php");
    exit;
}

// Récupérer les informations sur l'article à partir de la base de données
$sql = "SELECT * FROM articles WHERE id = $article_id";
$result = mysqli_query($conn, $sql);
$articles = mysqli_fetch_assoc($result);

// Si l'article n'a pas été trouvé, redirige l'utilisateur vers la page de gestion des articles
if (!$articles) {
    $_SESSION['message-failed'] = NO_ARTICLES;
    header("Location: gestion-articles.php");
    exit;
}

// Si le formulaire a été soumis
if (isset($_POST['submit'])) {

    // Supprimer l'utilisateur de la base de données
    $sql = "DELETE FROM articles WHERE id = $article_id";
    mysqli_query($conn, $sql);

    // Ajouter un message de réussite
    $_SESSION['message-success'] = ARTICLES_DELETE_SUCCESS;

    // Rediriger l'utilisateur vers la page de gestion des articles
    header("Location: gestion-articles.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thales - <?php echo ARTICLES_DELETE_TITLE?></title>
</head>

<body>
    <!-- Sidebar -->
    <?php include "navbar-admin.php"; ?>
    <!-- Contenu principal -->
    <div class="container mt-4">
        <!-- Contenu de la page -->
        <h1><?php echo ARTICLES_DELETE_TITLE?></h1>

        <p><?php echo ARTICLES_DELETE_CONFIRM?> <strong><?php echo $articles["name"]; ?></strong> ?</p>

        <form action="supprimer-article.php?id=<?php echo $article_id; ?>" method="post">
            <button type="submit" name="submit" class="btn btn-danger"><?php echo YES?></button>
            <a href="gestion-articles.php" class="btn btn-secondary"><?php echo NO?></a>
        </form>
    </div>
</body>

</html>