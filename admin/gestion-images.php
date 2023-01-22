<?php
// Importer la configuration de la base de données
require_once '../config.php';

// Vérifie si l'utilisateur à la permission de voir la page
if (!(check_permission($conn, 'manage_images'))) {
    // L'utilisateur n'a pas la permission, redirigez-le vers une autre page
    $_SESSION['message-failed'] = "Vous n'avez pas la permission de voir cette page.";
    header("Location: admin.php");
    exit;
}

// Requête pour récupérer toutes les images
$sql = "SELECT * FROM images";
$result = mysqli_query($conn, $sql);
$images = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Gestion des images</title>
</head>

<body>
    <!-- Barre de navigation -->
    <?php include "navbar-admin.php"; ?>

    <!-- Contenu principal -->
    <div class="container mt-4">

        <!-- Titre -->
        <h1>Gestion des images</h1>

        <!-- Affichage des images -->
        <?php if (empty($images)) { ?>
            <div class="alert alert-warning" role="alert">
                Il n'y a aucune image disponible pour être visualisée.
            </div>
        <?php } else { ?>
            <div class="row">
                <?php foreach ($images as $image) : ?>
                    <div class="col-3">
                        <div class="card mb-4">
                            <img src="<?php echo $image['file_path']; ?>" alt="<?php echo $image['name']; ?>" class="card-img-top">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $image['name']; ?></h5>
                                <a href="supprimer-image.php?id=<?php echo $image['id']; ?>" class="btn btn-danger">Supprimer</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php } ?>

        <div>
            <div class="float-right">
                <?php if ((check_permission($conn, 'create_articles'))) { ?>
                    <a href="creer-images.php" class="btn btn-success">Ajouter une image</a>
                <?php } ?>
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
        <div class="alert alert-failed alert-dismissible position-fixed mr-2 float-right" style="bottom: 10px; right: 20px;">
            <?php echo $_SESSION['message-failed']; ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <?php $_SESSION['message-failed'] = null; ?>
<?php }
} ?>