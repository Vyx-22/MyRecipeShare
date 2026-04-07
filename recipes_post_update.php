<?php session_start(); ?>
<?php
require_once(__DIR__ . '/isConnect.php');
require_once(__DIR__ . '/variables.php');
require_once(__DIR__ . '/login.php');
?>

<?php
$id = $_POST['id'];
$title = $_POST['title'];
$recipe = $_POST['recipe'];

if(!isset($id)||
!isset($title)||
!isset($recipe)

)
{
    echo 'Il faut un titre et une recette pour soumettre le formulaire. ';
    return;
}

// Faire l'insertion en base
$loggedUser_act = $_SESSION['LOGGED_USER'];
$insertRecipe = $mysqlClient->prepare('UPDATE recipes SET title = :title, recipe = :recipe WHERE recipe_id = :id');
$insertRecipe->execute([
    'title' => $title,
    'recipe' => $recipe,
    'id' => $id,
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
        <h1>Recette modifier avec succè!</h1>
        <div class="card">
        <div class="card-body">
            <h5 class="card-title"><?php echo$title; ?></h5>
            <p class="card-text"><b>Email</b> : <?php echo($loggedUser_act['email']); ?></p>
            <p class="card-text"><b>Recette</b> : <?php echo $recipe ?></p>
        
        </div>
    </div>
</body>
</html>