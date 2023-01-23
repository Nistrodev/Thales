<?php
// Importer le fihcier de config
require_once '../config.php';
// Vérifie si l'utilisateur a la permission de voir la page
if ((!check_permission($conn, 'view_admin_panel'))) {
    // L'utilisateur n'a pas la permission, redirigez-le vers une autre page
    header("Location: ../index.php");
    exit;
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Thales - Panel administrateur</title>
</head>

<body>

    <!-- Import la sidebar -->
    <?php include "navbar-admin.php" ?>
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Modification du logo de la navbar</h5>
                        <a href="modifier-logo-navbar.php" class="btn btn-primary">Modifier</a>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Modification des liens des réseaux sociaux</h5>
                        <a href="modifier-liens-reseaux-sociaux.php" class="btn btn-primary">Modifier</a>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Nombre total d'images: <?php echo get_images_count($conn); ?></h5>
                        <?php if ((check_permission($conn, 'manage_images'))) { ?>
                            <a href="gestion-images.php" class="btn btn-primary">Gérer les images</a>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Nombre total d'utilisateurs : <?php echo get_user_count($conn); ?></h5>
                        <?php if ((check_permission($conn, 'manage_users'))) { ?>
                            <a href="gestion-utilisateurs.php" class="btn btn-primary">Gérer les utilisateurs</a>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Nombre total de rôles : <?php echo get_role_count($conn); ?></h5>
                        <?php if ((check_permission($conn, 'manage_roles'))) { ?>
                            <a href="gestion-roles.php" class="btn btn-primary">Gérer les rôles</a>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Nombre total de catégories : <?php echo get_categories_count($conn); ?></h5>
                        <?php if ((check_permission($conn, 'manage_categories'))) { ?>
                            <a href="gestion-categories.php" class="btn btn-primary">Gérer les catégories</a>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Nombre total de sous-catégories : <?php echo get_subcategories_count($conn); ?></h5>
                        <?php if ((check_permission($conn, 'manage_subcategories'))) { ?>
                            <a href="gestion-sous-categories.php" class="btn btn-primary">Gérer les sous-catégories</a>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Nombre total d'articles : <?php echo get_articles_count($conn); ?></h5>
                        <?php if ((check_permission($conn, 'manage_articles'))) { ?>
                            <a href="gestion-articles.php" class="btn btn-primary">Gérer les articles</a>
                        <?php } ?>
                    </div>
                </div>
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