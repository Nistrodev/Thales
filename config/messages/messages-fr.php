<?php
// Config
define("ERROR_MYSQL", "Erreur MySQL : ");
define("RETOUR", "Retour");
define("CREER", "Créer");
define("VIEWS", "Voir");
define("MODIFY", "Modifier");
define("DELETE", "Supprimer");
define("PREVIOUS", "Précédent");
define("NEXT", "Suivant");
define("SEARCH", "Rechercher");
define("ADD", "Ajouter");
define("YES", "Oui");
define("NO", "Non");
define("VIEWS_PERMISSIONS", "Voir les permissions");
define("NO_ID_USERS", "Aucun ID d'utilisateur n'a été spécifié.");
define("NO_USERS", "Aucun utilisateur n'a été trouvé.");
define("NO_ID_CATEGORIES", "Aucun ID de catégorie n'a été spécifié.");
define("NO_CATEGORIES", "Aucune catégorie n'a été trouvé.");
define("NO_ID_SUBCATEGORIES", "Aucun ID de sous catégorie n'a été spécifié.");
define("NO_SUBCATEGORIES", "Aucune sous-catégorie trouvée.");
define("NO_ID_ARTICLES", "Aucun ID d'article n'a été spécifié.");
define("NO_ARTICLES", "Aucun article trouvé.");
define("NO_ID_ROLES", "Aucun ID de rôle n'a été spécifié.");
define("NO_ROLES", "Aucun rôle trouvé.");
define("NO_ID_IMAGES", "Aucun ID d'image n'a été spécifié.");
define("NO_IMAGES", "Aucune image trouvé.");

// Page login
define("ALREADY_LOGGED", "Vous êtes déjà connecté");
define("LOGIN_SUCCESS", "Vous êtes maintenant connecté.");
define("USERNAME_PASSWORD_INCORRECT", "Nom d'utilisateur ou mot de passe incorrect.");
define("LOGOUT_SUCCESS", "Vous êtes maintenant déconnecté.");
define("IDENTIFIANT_LABEL", "Identifiant");
define("PASSWORD_LABEL", "Mot de passe");
define("CONNEXION", "Connexion");
define("CONNECT", "Se connecter");


// Navbar
define("CREDITS_NAVBAR", " crédits");
define("PROFIL", "Mon profil");
define("RESERVATIONS", "Mes réservations");
define("ADMIN_PANEL", "Panel d'administrateur");
define("LOGOUT", "Déconnexion");
define("LOGIN", "Se connecter");

// Page d'accueil
define("NO_CONNECTED", "Vous devez être connecter pour accéder à cette page.");
define("BIENVENUE", "Bienvenue, ");

// Footer
define("SOCIAL_LINKS", "Réseaux sociaux");
define("CONTACT_US", "Contactez-nous");
define("INFOS", "Informations");
define("CONDITIONS", "Conditions générales d'utilisation");
define("CREDITS", "Crédits");

// Categorie
define("PRICE", "Prix :");
define("RESERVE", "Réserver");

// Article
define("CATEGORIES", "Catégorie :");


// Profil utilisateur
define("USER_PROFILE", "Profil utilisateur");
define("PROFIL_INFOS", "Informations de compte");
define("IDENTIFIANT", "Identifiant :");
define("EMAIL", "Adresse e-mail :");
define("NB_CREDITS", "Nombre de crédits :");

// Reservation
define("RESERVATION_SUCCESS", "Votre réservation a été soumise avec succès.");
define("RESERVATION_TITLE", "Réservation");
define("QUANTITY", "Quantité");
define("START_DATE", "Date dé début");
define("END_DATE", "Date de fin");

// Admin panel
define("NO_PERMISSIONS", "Vous n'avez pas la permission d'accéder à cette page.");
define("ADMIN_PANEL_TITLE", "Panel d'administateur");
define("MODIFY_NAVBAR", "Modification du logo de la navbar");
define("MODIFY_SOCIAL_LINKS", "Modification des liens des réseaux sociaux");
define("MODIFY_CATEGORIES", "Nombre total de catégories :");
define("MODIFY_IMAGES", "Nombre total d'images:");
define("MODIFY_USERS", "Nombre total d'utilisateurs :");
define("MODIFY_ROLES", "Nombre total de rôles :");
define("MODIFY_SUBCATEGORIES", "Nombre total de sous-catégories :");
define("MODIFY_ARTICLES", "Nombre total d'articles :");
define("MANAGE_IMAGES", "Gérer les images");
define("MANAGE_USERS", "Gérer les utilisateurs");
define("MANAGE_ROLES", "Gérer les rôles");
define("MANAGE_CATEGORIES", "Gérer les catégories");
define("MANAGE_SUBCATEGORIES", "Gérer les sous-catégories");
define("MANAGE_ARTICLES", "Gérer les articles");

// Ajouter credits
define("CREDITS_ADD_SUCCESS", "Le nombre de crédit de l'utilisateur à été modifié avec succès.");
define("CREDITS_ADD_TITLE", "Ajouter des crédits");
define("USERNAME", "Nom d'utilisateur");

// Création de rôle
define("ROLE_CREATE_SUCCESS", "Le rôle à été créer avec succès.");
define("ROLE_CREATE_TITLE", "Créer un rôle");
define("ROLE_CREATE_NAME", "Nom du rôle");
define("ROLE_CREATE_PERMISSION", "Permissions");

// Création articles
define("ARTICLE_CREATE_SUCCESS", "L'article à été créer avec succès.");
define("ARTICLE_CREATE_TITLE", "Création d'article");
define("ARTICLE_CREATE_NO_SUBCATEGORIES", "Il n'y a aucune sous-catégories disponible pour y créer un article.");
define("ARTICLE_CREATE_SUBCATEGORIES_BUTTON", "Créer une sous-catégorie");
define("ARTICLE_CREATE_NAME", "Nom");
define("ARTICLE_CREATE_DESCRIPTION", "Description");
define("ARTICLE_CREATE_PRICE", "Prix");
define("ARTICLE_CREATE_IMAGE", "Image");
define("ARTICLE_CREATE_SELECT_IMAGES", "Choissisez une image");
define("ARTICLE_CREATE_PARENT", "Catégorie parente");
define("ARTICLE_CREATE_SELECT_PARENT", "Choissisez une sous-catégorie parente");

// Création catégories
define("CATEGORIES_CREATE_SUCCESS", "La catégorie à été créer avec succès.");
define("CATEGORIES_CREATE_TITLE", "Création de catégorie");
define("CATEGORIES_CREATE_NAME", "Nom");
define("CATEGORIES_CREATE_BUTTON", "Créer");

// Création images
define("IMAGES_CREATE_ALREADY_EXISTS", "Ce nom d\'image existe déjà, veuillez en choisir un autre.");
define("IMAGES_CREATE_SUCCESS", "Image ajouté acec succès.");
define("IMAGES_CREATE_TITLE", "Ajout d'image");
define("IMAGES_CREATE_NAME", "Nom");
define("IMAGES_CREATE_IMAGE", "Image");

// Création sous catégories
define("SUBCATEGORIES_CREATE_NO_PARENT", "La catégorie parente n'a pas été trouvée.");
define("SUBCATEGORIES_CREATE_SUCCESS", "La sous catégorie à été créer avec succès.");
define("SUBCATEGORIES_CREATE_TITLE", "Création de sous-catégorie");
define("SUBCATEGORIES_CREATE_NO_CATEGORIES", "Il n'y a aucune catégorie disponible pour créer une sous-catégorie.");
define("SUBCATEGORIES_CREATE_NAME", "Nom");
define("SUBCATEGORIES_CREATE_PARENT", "Catégorie parente");
define("SUBCATEGORIES_CREATE_SELECT_PARENT", "Choissisez une catégorie parente");

// Création d'utilisateurs
define("USER_CREATE_SUCCESS", "L'utilisateur à été créer avec succès.");
define("USER_CREATE_TITLE", "Créer un utilisateur");
define("USER_CREATE_NAME", "Nom d'utilisateur");
define("USER_CREATE_PASSWORD", "Mot de passe");
define("USER_CREATE_EMAIL", "Email");
define("USER_CREATE_CREDITS", "Crédits");
define("USER_CREATE_ROLES", "Rôle");
define("USER_CREATE_SELECT_ROLES", "Choissisez un rôle");

// Gestion articles sous catégories
define("ARTICLE_SUBCATEGORIES_MANAGE_TITLE", ">Articles de la sous-catégorie");
define("ARTICLE_SUBCATEGORIES_MANAGE_ID", "ID");
define("ARTICLE_SUBCATEGORIES_MANAGE_NAME", "Nom");
define("ARTICLE_SUBCATEGORIES_MANAGE_DESCRIPTION", "Description");
define("ARTICLE_SUBCATEGORIES_MANAGE_PRICE", "Prix");
define("ARTICLE_SUBCATEGORIES_MANAGE_IMAGE", "Image");
define("ARTICLE_SUBCATEGORIES_MANAGE_ACTIONS", "Actions");
define("ARTICLE_SUBCATEGORIES_MANAGE_NO_IMAGES", "Aucune image");
define("ARTICLE_SUBCATEGORIES_MANAGE_NO_ARTICLES", "Il n'y a aucun articles pour cette catégorie.");
define("ARTICLE_SUBCATEGORIES_MANAGE_CREATE_ARTICLE", "Créer un article.");

// Gestion articles
define("ARTICLE_MANAGE_TITLE", "Gestion des articles");
define("ARTICLE_MANAGE_ID", "ID");
define("ARTICLE_MANAGE_SUBCATEGORIES", "Sous-Catégorie");
define("ARTICLE_MANAGE_ACTIONS", "Actions");
define("ARTICLE_MANAGE_VIEW_ARTICLE", "Voir les articles");
define("ARTICLE_MANAGE_VIEW_SUBCATEGORIES", "Voir la sous-catégorie");
define("ARTICLE_MANAGE_NO_ARTICLE", "Il n'y a aucun articles.");

// Gestion des catégories
define("CATEGORIES_MANAGE_TITLE", "Gestion des catégories");
define("CATEGORIES_MANAGE_ID", "ID");
define("CATEGORIES_MANAGE_NAME", "Nom");
define("CATEGORIES_MANAGE_NB_SUBCATEGORIES", "Nombre de sous-catégorie");
define("CATEGORIES_MANAGE_ACTIONS", "Actions");
define("CATEGORIES_MANAGE_NO_CATEGORIES", "Il n'y a aucune catégorie.");
define("CATEGORIES_MANAGE_CREATE_CATEGORIES", "Créer une catégorie");

// Gestion des crédits
define("CREDITS_MANAGE_TITLE", "Gestion des crédits");
define("CREDITS_MANAGE_ID", "ID");
define("CREDITS_MANAGE_NAME", "Nom");
define("CREDITS_MANAGE_EMAIL", "Email");
define("CREDITS_MANAGE_CREDITS", "Crédits");
define("CREDITS_MANAGE_ACTIONS", "Actions");

// Gestion des images
define("IMAGES_MANAGE_TITLE", "Gestion des images");
define("IMAGES_MANAGE_NO_IMAGES", "Il n'y a aucune image disponible pour être visualisée.");
define("IMAGES_MANAGE_ADD", "Ajouter une image");

// Gestion des rôles
define("ROLES_MANAGE_TITLE", "Gestion des rôles");
define("ROLES_MANAGE_ID", "ID");
define("ROLES_MANAGE_ROLE", "Rôles");
define("ROLES_MANAGE_NB_USERS", "Nombre d'utilisateurs");
define("ROLES_MANAGE_PERMISSIONS", "Permissions");
define("ROLES_MANAGE_ACTIONS", "Actions");
define("ROLES_MANAGE_CREATE", "Créer un rôle");

// Gestion des sous catégories
define("SUBCATEGORIES_MANAGE_TITLE", "Gestion des Sous-Catégories");
define("SUBCATEGORIES_MANAGE_ID", "ID");
define("SUBCATEGORIES_MANAGE_NAME", "Nom");
define("SUBCATEGORIES_MANAGE_PARENT", "Catégorie Parente");
define("SUBCATEGORIES_MANAGE_ACTIONS", "Actions");
define("SUBCATEGORIES_MANAGE_NO_SUBCATEGORIES", "Il n'y a aucune sous-catégorie.");
define("SUBCATEGORIES_MANAGE_CREATE", "Créer une sous-catégorie");

// Gestion des utilisateurs
define("USERS_MANAGE_TITLE", "Gestion des utilisateurs");
define("USERS_MANAGE_ID", "ID");
define("USERS_MANAGE_NAME", "Nom");
define("USERS_MANAGE_EMAIL", "Email");
define("USERS_MANAGE_CREDITS", "Crédits");
define("USERS_MANAGE_ROLE", "Rôle");
define("USERS_MANAGE_ACTIONS", "Actions");
define("USERS_MANAGE_CREATE", "Créer un utilisateur");

// Modifier article
define("ARTICLE_MODIFY_TITLE", "Modifier un article");
define("ARTICLE_MODIFY_SUCCESS", "L'article à été modifié avec succès.");
define("ARTICLE_MODIFY_NAME", "Nom");
define("ARTICLE_MODIFY_DESCRIPTION", "Description");
define("ARTICLE_MODIFY_PRICE", "Prix");
define("ARTICLE_MODIFY_IMAGE", "Image");
define("ARTICLE_MODIFY_SELECT_IMAGE", "Choisissez une image");
define("ARTICLE_MODIFY_SUBCATEGORIES", "Sous-catégorie");
define("ARTICLE_MODIFY_SELECT_SUBCATEGORIES", "Choisissez une sous-catégorie");

// Modifier catégorie
define("CATEGORIE_MODIFY_SUCCESS", "La catégorie à été modifié avec succès.");
define("CATEGORIE_MODIFY_TITLE", "Modification de la catégorie");
define("CATEGORIE_MODIFY_NAME", "Nom");

// Modifier logo navbar
define("LOGO_NAVBAR_MODIFY_SUCCESS", "Le logo à été modifié avec succès.");
define("LOGO_NAVBAR_MODIFY_TITLE", "Modification du logo");
define("LOGO_NAVBAR_MODIFY_IMAGE", "Image");
define("LOGO_NAVBAR_MODIFY_SELECT_IMAGE", "Choissisez une image");
define("LOGO_NAVBAR_MODIFY_NO_SOURCE", "Aucune source n'est définie pour l'image.");
define("LOGO_NAVBAR_MODIFY_NO_IMAGES_SELECTED", "Aucune image sélectionnée");

// Modifier roles
define("ROLES_MODIFY_SUCCESS", "Le rôle à été modifié avec succès.");
define("ROLES_MODIFY_TITLE", "Modifier un rôle");
define("ROLES_MODIFY_NAME", "Nom du rôle");
define("ROLES_MODIFY_PERMISSIONS", "Permissions");

// Modifier catégories
define("CATEGORIES_MODIFY_SUCCESS", "La sous-catégorie à été modifié avec succès.");
define("CATEGORIES_MODIFY_TITLE", "Modification de la sous-catégorie");
define("CATEGORIES_MODIFY_NAME", "Nom");
define("CATEGORIES_MODIFY_PARENT", "Permissions");
define("CATEGORIES_MODIFY_SELECT_PARENT", "Permissions");

// Modifier utilisateurs
define("USERS_MODIFY_SUCCESS", "L'utilisateur à été modifié avec succès.");
define("USERS_MODIFY_TITLE", "Modifier un utilisateur");
define("USERS_MODIFY_NAME", "Nom");
define("USERS_MODIFY_PASSWORD", "Mot de passe");
define("USERS_MODIFY_EMAIL", "Email");
define("USERS_MODIFY_CREDITS", "Crédits");
define("USERS_MODIFY_ROLE", "Rôle");
define("USERS_MODIFY_SELECT_ROLE", "Choissisez un rôle");

// Navbar admin
define("NAVBAR_ADMIN_HOME", "Accueil");
define("NAVBAR_ADMIN_IMAGES", "Gestion des images");
define("NAVBAR_ADMIN_USERS", "Gestion des utilisateurs");
define("NAVBAR_ADMIN_ROLES", "Gestion des rôles");
define("NAVBAR_ADMIN_CREDITS", "Gestion des crédits");
define("NAVBAR_ADMIN_CATEGORIES", "Gestion des catégories");
define("NAVBAR_ADMIN_SUBCATEGORIES", "Gestion des sous-catégories");
define("NAVBAR_ADMIN_ARTICLES", "Gestion des articles");
define("NAVBAR_ADMIN_RETURN", "Retour au site");

// Supprimer les articles
define("ARTICLES_DELETE_SUCCESS", "L'article à été supprimé avec succès.");
define("ARTICLES_DELETE_TITLE", "Supprimer un article");
define("ARTICLES_DELETE_CONFIRM", "Êtes-vous sûr de vouloir supprimer l'article");

// Supprimer les catégories
define("CATEGORIES_DELETE_SUCCESS", "La catégorie à été supprimé avec succès.");
define("CATEGORIES_DELETE_TITLE", "Supprimer une catégorie");
define("CATEGORIES_DELETE_CONFIRM", "Êtes-vous sûr de vouloir supprimer la catégorie");
define("CATEGORIES_DELETE_CONTAINS_SUBCATEGORIES", "Impossible de supprimer cette catégorie car elle contient des sous-catégories.");

// Supprimer les crédits
define("CREDITS_DELETE_SUCCESS", "Le nombre de crédits de l'utilisateur à été supprimé avec succès.");
define("CREDITS_DELETE_TITLE", "Supprimer les crédits");
define("CREDITS_DELETE_CONFIRM", "Êtes-vous sûr de vouloir supprimer les crédits de l'utilisateur");

// Supprimer les images
define("IMAGES_DELETE_SUCCESS", "L'image à été supprimé avec succès.");
define("IMAGES_DELETE_TITLE", "Supprimer une image");
define("IMAGES_DELETE_CONFIRM", "Êtes-vous sûr de vouloir supprimer l'image");

// Supprimer les rôles
define("ROLES_DELETE_SUCCESS", "Le rôle a été supprimé avec succès.");
define("ROLES_DELETE_TITLE", "Supprimer un rôle");
define("ROLES_DELETE_CONFIRM", "Êtes-vous sûr de vouloir supprimer le rôle");
define("ROLES_DELETE_ADMIN_USER", "Impossible de supprimer ce rôle");

// Supprimer une sous catégorie
define("SUBCATEGORIES_DELETE_SUCCESS", "La sous catégorie à été supprimé avec succès.");
define("SUBCATEGORIES_DELETE_TITLE", "Supprimer une sous-catégorie");
define("SUBCATEGORIES_DELETE_CONFIRM", "Êtes-vous sûr de vouloir supprimer la sous-catégories");
define("SUBCATEGORIES_DELETE_ARTICLES", "Il reste des articles dans cette sous-catégorie, vous ne pouvez pas la supprimer.");

// Supprimer un utilisateur
define("USERS_DELETE_SUCCESS", "L'utilisateur à été supprimé avec succès.");
define("USERS_DELETE_TITLE", "Supprimer un utilisateur");
define("USERS_DELETE_CONFIRM", "Êtes-vous sûr de vouloir supprimer l'utilisateur");
define("USERS_DELETE_ADMIN", "Impossible de supprimer l'utilisateur 'admin'");

// Voir les permissions
define("VIEWS_PERMISSIONS_TITLE", "Permissions du rôle");
define("VIEWS_PERMISSIONS_NO_PERMISSIONS1", "Le role ");
define("VIEWS_PERMISSIONS_NO_PERMISSIONS2", " n'a aucune permission.");
define("VIEWS_PERMISSIONS_PERMISSIONS", "Permission");