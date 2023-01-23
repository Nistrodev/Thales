<?php
// Importer la base de données
include '../config.php';

// Vérifie si l'utilisateur à la permission de voir la page
if (!(check_permission($conn, 'delete_articles'))) {
    // L'utilisateur n'a pas la permission, redirigez-le vers une autre page
    $_SESSION['message-failed'] = "Vous n'avez pas la permission de voir cette page.";
    header("Location: admin.php");
    exit;
}

// Récupérer l'ID de l'article à partir de la requête GET
$article_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Si aucun ID d'article n'a été spécifié, rediriger l'utilisateur vers la page de gestion des articles
if (!$article_id) {
    header("Location: gestion-articles.php");
    exit;
}

// Récupérer les informations sur l'article à partir de la base de données
$sql = "SELECT * FROM articles WHERE id = $article_id";
$result = mysqli_query($conn, $sql);
$articles = mysqli_fetch_assoc($result);

// Si l'article n'a pas été trouvé, redirige l'utilisateur vers la page de gestion des articles
if (!$articles) {
    header("Location: gestion-articles.php");
    exit;
}

// Si le formulaire a été soumis
if (isset($_POST['submit'])) {

    // Supprimer l'utilisateur de la base de données
    $sql = "DELETE FROM articles WHERE id = $article_id";
    mysqli_query($conn, $sql);

    // Ajouter un message de réussite
    $_SESSION['message-success'] = "L'article à été supprimé avec succès.";

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
    <title>Thales - Supprimer un article</title>
</head>

<body>
    <!-- Sidebar -->
    <?php include "navbar-admin.php"; ?>
    <!-- Contenu principal -->
    <div class="container mt-4">
        <!-- Contenu de la page -->
        <h1>Supprimer un article</h1>

        <p>Êtes-vous sûr de vouloir supprimer l'article <strong><?php echo $articles["name"]; ?></strong> ?</p>

        <form action="supprimer-article.php?id=<?php echo $article_id; ?>" method="post">
            <button type="submit" name="submit" class="btn btn-danger">Oui</button>
            <a href="gestion-articles.php" class="btn btn-secondary">Non</a>
        </form>
    </div>
</body>

</html>