<?php
// Démarrer la session
session_start();

// Inclusion du fichier config.php
require_once "config.php";
require_once "navbar.php";

// Si l'utilisateur est déjà connecté, redirige vers la page d'accueil
if (is_logged()) {
    $_SESSION['message-success'] = ALREADY_LOGGED;
    // Redirection vers la page protégée
    header("Location: index.php");
    exit;
}

// Si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupération des données du formulaire
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Requête pour récupérer l'utilisateur avec le nom d'utilisateur spécifié
    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $sql);

    // Si l'utilisateur existe
    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);

        // Vérification du mot de passe
        if (password_verify($password, $user['password'])) {
            // Connexion réussie
            // Enregistrer le nom d'utilisateur dans la variable de session
            $_SESSION['username'] = $username;

            // Affiche un message de succès
            $_SESSION['message-success'] = LOGIN_SUCCESS;

            // Redirection vers la page protégée
            header("Location: index.php");
            exit;
        } else {
            // Mot de passe incorrect
            // Afficher un message d'erreur
            $error = USERNAME_PASSWORD_INCORRECT;
        }
    }
}
?>
<div class="container mt-5">
    <h1><?php echo CONNEXION?></h1>
    <?php if (isset($error)) { ?>
        <div class="alert alert-danger">
            <?php echo $error; ?>
        </div>
    <?php } ?>
    <form action="" method="post">
        <div class="form-group">
            <label for="username"><?php echo IDENTIFIANT?></label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="form-group">
            <label for="password"><?php echo PASSWORD_LABEL?></label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary"><?php echo CONNECT?></button>
    </form>
</div>

<?php require_once "footer.php";?>

<?php

if (isset($error)) {
    echo $error;
}

// Fermeture de la connexion
mysqli_close($conn);

?>

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