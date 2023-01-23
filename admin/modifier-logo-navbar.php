<?php
// Importer la base de données
include '../config.php';

// Vérifie si l'utilisateur à la permission de voir la page
if (!(check_permission($conn, 'modify_logo_navbar'))) {
    // L'utilisateur n'a pas la permission, redirigez-le vers une autre page
    $_SESSION['message-failed'] = "Vous n'avez pas la permission de voir cette page.";
    header("Location: admin.php");
    exit;
}


// Si le formulaire a été soumis
if (isset($_POST['submit'])) {
    // Récupérer les données du formulaire
    $image = mysqli_real_escape_string($conn, $_POST['image']);

    // Créer la sous-catégorie
    $sql = "UPDATE navbar_logo SET id=1,image_path='$image' WHERE 1";
    mysqli_query($conn, $sql);

    // Rediriger l'utilisateur vers la page de gestion des catégories
    header("Location: admin.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thales - Modification logo navbar</title>
</head>

<body>
    <!-- Barre de navigation -->
    <?php include "navbar-admin.php"; ?>
    <!-- Contenu principal -->
    <div class="container mt-4">
        <!-- Contenu de la page -->
        <h1>Modification logo navbar</h1>
        <!-- Formulaire de création de sous-catégorie -->
        <form action="modifier-logo-navbar.php" method="post">
            <!-- Nom de la sous-catégorie -->
            <div class="form-group">
                <div class="form-group">
                    <label for="image">Image</label>
                    <select class="form-control" id="image" name="image" required>
                        <option value="" selected disabled hidden>Choissisez une image</option>
                        <?php
                        $sql = "SELECT * FROM images";
                        $result = mysqli_query($conn, $sql);
                        $images = mysqli_fetch_all($result, MYSQLI_ASSOC);
                        foreach ($images as $image) {
                        ?>

                            <option value="<?php echo $image['file_path']; ?>">
                                <?php echo $image['name']; ?>
                            </option>
                        <?php }; ?>
                    </select>
                </div>
                <div class="form-group">
                    <p></p>
                    <img src="" alt="logo" id="img" style="width: 150px;">
                </div>



            </div>
            <!-- Bouton de soumission -->
            <a href="admin.php" class="btn btn-secondary">Retour</a>
            <button type="submit" name="submit" class="btn btn-primary">Modifier</button>
        </form>
    </div>

    <script>
        var img = $("#img");
        if (img.attr("src") === "") {
            $("img").css("display", "none");
            $("p").html("Aucune source n'est définie pour l'image.");
            console.log("coucou")
        }
        $(document).ready(function() {
            $('#image').on('change', function() {
                var image = this.value;
                $('img').attr('src', image);
                if (image == "") {
                    $('img').text("Aucune image sélectionnée");
                } else {
                    $('img').text("");
                }


                $("img").css("display", "block");
                $("p").html("")

            });

        });
    </script>




</body>

</html>