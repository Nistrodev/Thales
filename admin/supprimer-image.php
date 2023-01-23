<?php
// Importer la base de données
include '../config.php';

// Vérifie si l'utilisateur à la permission de voir la page
if (!(check_permission($conn, 'delete_images'))) {
    // L'utilisateur n'a pas la permission, redirigez-le vers une autre page
    $_SESSION['message-failed'] = NO_PERMISSIONS;
    header("Location: admin.php");
    exit;
}

// Récupérer l'ID de l'image à partir de la requête GET
$image_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Si aucun ID d'image n'a été spécifié, rediriger l'utilisateur vers la page de gestion des images
if (!$image_id) {
    $_SESSION['mesage-failed'] = NO_ID_IMAGES;
    header("Location: gestion-images.php");
    exit;
}

// Récupérer les informations sur l'image à partir de la base de données
$sql = "SELECT * FROM images WHERE id = $image_id";
$result = mysqli_query($conn, $sql);
$image = mysqli_fetch_assoc($result);

// Si l'image n'a pas été trouvé, rediriger l'utilisateur vers la page de gestion des images
if (!$image) {
    $_SESSION['message-failed'] = NO_IMAGES;
    header("Location: gestion-images.php");
    exit;
}

// Si le formulaire a été soumis
if (isset($_POST['submit'])) {

    // Supprimer l'image de la base de données
    $sql = "DELETE FROM images WHERE id = $image_id";
    mysqli_query($conn, $sql);

    // Supprimer le fichier image du système de fichiers
    unlink("../uploads/" . $image['file_name']);

    // Ajouter un message de réussite
    $_SESSION['message-failed'] = IMAGES_DELETE_SUCCESS;

    // Rediriger l'utilisateur vers la page de gestion des images
    header("Location: gestion-images.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thales - <?php echo IMAGES_DELETE_TITLE?></title>
</head>

<body>
    <!-- Sidebar -->
    <?php include "navbar-admin.php"; ?>
    <!-- Contenu principal -->
    <div class="container mt-4">
        <!-- Contenu de la page -->
        <h1><?php echo IMAGES_DELETE_TITLE?></h1>

        <p><?php echo IMAGES_DELETE_CONFIRM?> <strong><?php echo $image["name"]; ?></strong> ?</p>

        <form action="supprimer-image.php?id=<?php echo $image_id; ?>" method="post">
            <button type="submit" name="submit" class="btn btn-danger"><?php echo YES?></button>
            <a href="gestion-images.php" class="btn btn-secondary"><?php echo NO?></a>
        </form>
    </div>
</body>

</html>