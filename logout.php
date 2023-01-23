<?php

// Démarrer la session
session_start();

// Détruire la session
session_destroy();

// Affiche un message
$_SESSION['message-success'] = LOGOUT_SUCCESS;

// Redirection vers la page de connexion
header("Location: index.php");
exit;

?>
