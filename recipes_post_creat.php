<?php session_start(); ?>
<?php
require_once(__DIR__ . '/isConnect.php');
require_once(__DIR__ . '/variables.php');
require_once(__DIR__ . '/login.php');
?>

<?php
if(!isset($_POST['title']) || 
!isset($_POST['recipe']) || 
empty(trim($_POST['title'])) || 
empty(trim($_POST['recipe'])))
{
    echo 'Il faut un titre et une recette pour soumettre le formulaire. ';
    return;
}

$title =  htmlspecialchars($_POST['title']);
$recipe =  htmlspecialchars($_POST['recipe']);

// Faire l'insertion en base
$loggedUser_act = $_SESSION['LOGGED_USER'];
$insertRecipe = $mysqlClient->prepare('INSERT INTO recipes(title, recipe, author, is_enabled) VALUES (:title, :recipe, :author, :is_enabled) ');
$insertRecipe->execute([
    'title' => $title,
    'recipe' => $recipe,
    'is_enabled' => 1,
    'author' => $loggedUser_act['email'], 
    ]);

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site de Recettes - recette ajoutée</title>
    <link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
rel="stylesheet"
>
</head>

<body>
    <div class="container">
        <?php require_once(__DIR__ . '/header.php'); ?>
        <h1>Recette ajoutée avec succès!</h1>
        <div class="card">
        <div class="card-body">
            <h5 class="card-title"><?php echo$title; ?></h5>
            <p class="card-text"><b>Email</b> : <?php echo($loggedUser_act['email']); ?></p>
            <p class="card-text"><b>Recette</b> : <?php echo $recipe ?></p>
        
        </div>
    </div>
    <?php require_once(__DIR__ . '/footer.php'); ?>
</body>
</html>