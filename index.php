<?php

// Démarrer la session
session_start();

require_once "navbar.php";

// Si l'utilisateur n'est pas connecté
if (!isset($_SESSION['username'])) {
    // Afficher le message "Vous devez vous connecter pour accéder à cette page"
    echo NO_CONNECTED;
} else {
    // L'utilisateur est connecté
    // Afficher le message "Bienvenue, utilisateur_connecté"
    echo BIENVENUE . $_SESSION['username'];
}

require_once "footer.php";
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