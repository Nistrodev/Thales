<?php
// Importer la base de données
include '../config.php';

// Vérifie si l'utilisateur à la permission de voir la page
if (!(check_permission($conn, 'add_images'))) {
    // L'utilisateur n'a pas la permission, redirigez-le vers une autre page
    $_SESSION['message-failed'] = NO_PERMISSIONS;
    header("Location: admin.php");
    exit;
}

// Si le formulaire a été soumis
if (isset($_POST['submit'])) {
    // Récupérer les données du formulaire
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $file_name = $_FILES['image']['name'];
    $file_temp = $_FILES['image']['tmp_name'];
    $file_path = "../uploads/" . $file_name;
    move_uploaded_file($file_temp, $file_path);

    // Vérifie si le nom d'image existe déjà
    if (check_if_image_exists($conn, $name)) {
        echo '<p class="text-danger text-center">'?> <?php echo IMAGES_CREATE_ALREADY_EXISTS?> <?php '</p>';
    } else {
        $sql = "INSERT INTO `images`(`name`, `file_name`, `file_path`) VALUES ('$name', '$file_name', '$file_path')";
        mysqli_query($conn, $sql);
        $_SESSION['message-success'] = IMAGES_CREATE_SUCCESS;
        // Rediriger l'utilisateur vers la page de gestion des catégories
        header("Location: gestion-images.php");
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
    <title>Thales - <?php echo IMAGES_CREATE_TITLE?></title>
</head>

<body>
    <!-- Barre de navigation -->
    <?php include "navbar-admin.php"; ?>
    <!-- Contenu principal -->
    <div class="container mt-4">
        <!-- Contenu de la page -->
        <h1><?php echo IMAGES_CREATE_TITLE?></h1>
        <form action="creer-images.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name"><?php echo IMAGES_CREATE_NAME?></label>
                <input type="text" class="form-control" name="name" id="name" required>
                <label for="image"><?php echo IMAGES_CREATE_IMAGE?></label>
                <input type="file" class="form-control-file" name="image" id="image" accept="image/*" required>
            </div>
            <p class="error" style="display:none"></p>
            <!-- Bouton de soumission -->
            <a href="gestion-images.php" class="btn btn-secondary"><?php echo RETOUR?></a>
            <button type="submit" name="submit" id="submit" class="btn btn-primary"><?php echo CREER?></button>
        </form>
    </div>
</body>

</html>