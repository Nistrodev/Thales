<?php
// Importer la base de données
include '../config.php';

// Vérifie si l'utilisateur à la permission de voir la page
if (!(check_permission($conn, 'create_articles'))) {
    // L'utilisateur n'a pas la permission, redirigez-le vers une autre page
    $_SESSION['message-success'] = "Vous n'avez pas la permission de voir cette page.";
    header("Location: admin.php");
    exit;
}

// Récupération de l'ID de la sous-catégorie depuis l'URL
$subcategory_id = isset($_GET['subcategory_id']) ? intval($_GET['subcategory_id']) : 0;

// Requête pour récupérer toutes les sous-catégories
$sql = "SELECT * FROM subcategories";
$result = mysqli_query($conn, $sql);
$subcategories = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Si un ID de sous-catégorie a été spécifié, récupérer le nom de la sous-catégorie
if ($subcategory_id) {
    $sql = "SELECT name FROM subcategories WHERE id = $subcategory_id";
    $result = mysqli_query($conn, $sql);
    $subcategory_name = mysqli_fetch_assoc($result)['name'];
}
// Si le formulaire a été soumis
if (isset($_POST['submit'])) {
    // Récupérer les données du formulaire
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $image = mysqli_real_escape_string($conn, $_POST['image']);
    $parent_id = mysqli_real_escape_string($conn, $_POST['parent_id']);

    // Vérifier que la catégorie parente existe
    $sql = "SELECT * FROM subcategories WHERE id='$parent_id' LIMIT 1";
    $result = mysqli_query($conn, $sql);
    $parent = mysqli_fetch_assoc($result);
    if (!$parent) {
        // La catégorie parente n'a pas été trouvée, afficher un message d'erreur
        $error_msg = "La catégorie parente avec l'identifiant '$parent_id' n'a pas été trouvée.";
    } else {
        // Créer la sous-catégorie
        $sql = "INSERT INTO articles (name, description, price, image, subcategory_id) VALUES ('$name', '$description', '$price', '$image', '$parent_id')";
        mysqli_query($conn, $sql);

        // Rediriger l'utilisateur vers la page de gestion des catégories
        header("Location: gestion-articles.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thales - Création d'article</title>
</head>

<body>
    <!-- Barre de navigation -->
    <?php include "navbar-admin.php"; ?>
    <!-- Contenu principal -->
    <div class="container mt-4">
        <!-- Contenu de la page -->
        <h1>Création d'article</h1>
        <?php if (empty($subcategories)) { ?>
            <div class="alert alert-warning" role="alert">
                Il n'y a aucune sous-catégories disponible pour y créer un article.
            </div>
            <a href="gestion-articles.php" class="btn btn-secondary">Retour</a>
            <a href="gestion-sous-categories.php" class="btn btn-success">Créer une sous-catégorie</a>
        <?php } else { ?>
            <!-- Formulaire de création de sous-catégorie -->
            <form action="creer-articles.php" method="post">
                <!-- Nom de la sous-catégorie -->
                <div class="form-group">
                    <label for="name">Nom</label>
                    <input type="text" class="form-control" name="name" id="name" required>
                    <label for="description">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    <label for="price">Prix</label>
                    <input type="number" class="form-control" name="price" id="price" required>
                    <div class="form-group">
                        <label for="image">Image</label>
                        <select class="form-control" id="image" name="image">
                            <?php
                            $sql = "SELECT * FROM images";
                            $result = mysqli_query($conn, $sql);
                            $images = mysqli_fetch_all($result, MYSQLI_ASSOC);
                            foreach ($images as $image) {
                            ?>

                                <option value="" selected disabled hidden>Choissisez une image</option>
                                <option value="<?php echo $image['file_path']; ?>">
                                    <?php echo $image['name']; ?>
                                </option>
                            <?php }; ?>
                        </select>
                    </div>

                </div>
                <!-- Catégorie parente -->
                <div class="form-group">
                    <label for="parent_id">Catégorie parente</label>
                    <select class="form-control" name="parent_id" id="parent_id" required>
                        <?php if ($subcategory_id) { ?>
                            <option value="<?php echo $subcategory_id; ?>" selected><?php echo $subcategory_name; ?></option>
                        <?php } else { ?>
                            <!-- Liste des catégories -->
                            <option value="" selected disabled hidden>Choissisez une sous-catégorie parente</option>
                            <?php foreach ($subcategories as $subcategory) { ?>
                                <option value="<?php echo $subcategory['id']; ?>"><?php echo $subcategory['name']; ?></option>
                        <?php }
                        } ?>
                    </select>
                </div>
                <!-- Bouton de soumission -->
                <a href="gestion-articles.php" class="btn btn-secondary">Retour</a>
                <button type="submit" name="submit" class="btn btn-primary">Créer</button>
            </form>
        <?php } ?>
    </div>
</body>

</html>