<?php

// Démarrer la session
session_start();

require_once "navbar.php";

// Si l'utilisateur n'est pas connecté
if (!isset($_SESSION['username'])) {
    // Afficher le message "Vous devez vous connecter pour accéder à cette page"
    echo "Vous devez vous connecter pour accéder à cette page";
} else {
    // L'utilisateur est connecté
    // Afficher le message "Bienvenue, utilisateur_connecté"
    echo "Bienvenue, " . $_SESSION['username'];
}

require_once "footer.php";
?>