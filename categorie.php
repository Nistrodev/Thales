<?php
// Inclusion du fichier config.php
require_once "config.php";

// Récupération de l'ID de la sous-catégorie passée dans l'URL
$subcategory_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Si aucun ID de sous catégories n'a été spécifié, rediriger l'utilisateur vers la page principale
if (!$subcategory_id) {
   header("Location: index.php");
   exit;
}

// Récupération des articles de la sous-catégorie
$articles_query = "SELECT * FROM articles WHERE subcategory_id = $subcategory_id";
$articles_result = mysqli_query($conn, $articles_query);
$articles = mysqli_fetch_all($articles_result, MYSQLI_ASSOC);

if (!$articles_result) {
    echo "Erreur MySQL : " . mysqli_error($conn);
}

// Récupération de la sous-catégorie
$subcategory_query = "SELECT * FROM subcategories WHERE id = $subcategory_id";
$subcategory_result = mysqli_query($conn, $subcategory_query);
$subcategory = mysqli_fetch_assoc($subcategory_result);

if (!$subcategory_result) {
    echo "Erreur MySQL : " . mysqli_error($conn);
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Thales - <?php echo $subcategory['name']; ?></title>
</head>

<body>
    <!-- Include navbar -->
    <?php include 'navbar.php'; ?>

    <h1 class="text-center"><?php echo $subcategory['name']; ?></h1>
    <div class="container">
        <div class="row">
            <?php foreach ($articles as $article) { ?>
                <div class="col-sm-4">
                    <div class="card">
                        <img src="<?php echo $article['image']; ?>" class="card-img-top" alt="">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $article['name']; ?></h5>
                            <p class="card-text"><?php echo $article['description']; ?></p>
                            <p class="card-text">Prix : <?php echo $article['price']; ?></p>
                            <a href="article.php?id=<?php echo $article['id'];?>" class="btn btn-success">Voir</a>
                            <a href="#" class="btn btn-primary">Réserver</a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
    
    <?php require_once "footer.php"; ?>
</body>

</html>