<?php
// Importer la base de données
include '../config.php';

// Vérifie si l'utilisateur à la permission de voir la page
if (!(check_permission($conn, 'modify_articles'))) {
    // L'utilisateur n'a pas la permission, redirigez-le vers une autre page
    $_SESSION['message-failed'] = "Vous n'avez pas la permission de voir cette page.";
    header("Location: gestion-articles.php");
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
$article = mysqli_fetch_assoc($result);

// Requête pour récupérer toutes les sous-catégories
$sql = "SELECT * FROM subcategories";
$result = mysqli_query($conn, $sql);
$subcategories = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Si l'article n'a pas été trouvé, rediriger l'utilisateur vers la page de gestion des articles
if (!$article) {
    header("Location: gestion-articles.php");
    exit;
}


// Si le formulaire a été soumis
if (isset($_POST['submit'])) {
    // Récupérer les données du formulaire
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = intval($_POST['price']);
    $image = mysqli_real_escape_string($conn, $_POST['image']);
    $parent_id = mysqli_real_escape_string($conn, $_POST['parent_id']);

    $update_sql = "UPDATE articles SET subcategory_id='$parent_id',name='$name',description='$description',price='$price',image='$image' WHERE id=$article_id";
    mysqli_query($conn, $update_sql);

    // Ajouter un message de réussite
    $_SESSION['message-success'] = "L'article à été modifié avec succès.";

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
    <title>Thales - Modifier un article</title>
</head>

<body>
    <!-- Sidebar -->
    <?php include "navbar-admin.php"; ?>
    <!-- Contenu principal -->
    <div class="container mt-4">
        <!-- Contenu de la page -->
        <h1>Modifier un article</h1>
        <form action="modifier-article.php?id=<?php echo $article_id; ?>" method="post">
            <div class="form-group">
                <label for="name">Nom</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo $article['name']; ?>">
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <input type="text" class="form-control" id="description" name="description" value="<?php echo $article['description']; ?>">
            </div>
            <div class="form-group">
                <label for="price">Prix</label>
                <input type="number" class="form-control" id="price" name="price" value="<?php echo $article['price']; ?>">
            </div>
            <div class="form-group">
                <label for="image">Image</label>
                <select class="form-control" id="image" name="image">
                    <?php
                    $sql = "SELECT * FROM images";
                    $result = mysqli_query($conn, $sql);
                    $images = mysqli_fetch_all($result, MYSQLI_ASSOC);
                    ?>
                    <option value="" selected disabled hidden>Choisissez une image</option>
                    <?php foreach ($images as $image) { ?>
                        <option value="<?php echo $image['file_path']; ?>" <?php echo $article['image'] === $image['file_path'] ? 'selected' : ''; ?>>
                            <?php echo $image['name']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group">
                <label for="parent_id">Sous-catégorie</label>
                <select class="form-control" id="parent_id" name="parent_id">
                    <option value="" selected disabled hidden>Choisissez une sous-catégorie</option>
                    <?php foreach ($subcategories as $subcategory) : ?>
                        <option value="<?php echo $subcategory['id']; ?>" <?php echo $article['subcategory_id'] === $subcategory['id'] ? 'selected' : ''; ?>>
                            <?php echo $subcategory['name']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <a href="gestion-articles.php" class="btn btn-secondary">Retour</a>
            <button type="submit" name="submit" class="btn btn-primary">Modifier</button>
        </form>
    </div>
</body>

</html>