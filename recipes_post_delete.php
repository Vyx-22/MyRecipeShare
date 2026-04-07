<?php session_start(); ?>
<?php
require_once(__DIR__ . '/isConnect.php');
require_once(__DIR__ . '/variables.php');
require_once(__DIR__ . '/login.php');
?>

<?php
$id = $_POST['id'];

if(!isset($id)
)
{
    echo 'Recette existe pas ';
    return;
}

// Faire l'insertion en base
$loggedUser_act = $_SESSION['LOGGED_USER'];
$deleteteRecipe = $mysqlClient->prepare('DELETE FROM recipes WHERE recipe_id=:id');
$deleteteRecipe->execute([
    'id' => $id,
    ]);

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site de Recettes - recette supprimée</title>
    <link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
rel="stylesheet"
>
</head>

<body>
    <div class="container">
        <?php require_once(__DIR__ . '/header.php'); ?>
        
        <?php if ($deleteteRecipe) {
                echo "<h1>Recette supprimée avec succès !</h1>";
                echo "✅ La suppression a réussi !";
            } else {
                echo "❌ La suppression a échoué.";
            
            }
        ?>
    </div>

</body>
</html>