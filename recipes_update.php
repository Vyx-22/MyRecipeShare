<?php session_start(); ?>
<?php require_once(__DIR__ . '/variables.php'); ?>
<?php
$id = $_GET['id'];

if (!isset($id) || !is_numeric($id)) {
    echo 'Il faut un identifiant de recette valide pour la modifier.';
    return;
}

$retrieveRecipeStatement = $mysqlClient->prepare('SELECT * FROM recipes WHERE recipe_id = :id');
$retrieveRecipeStatement->execute([
    'id' => $id,
]);

$recipe = $retrieveRecipeStatement->fetch(PDO::FETCH_ASSOC);

?> 
<!DOCTYPE html>
<html>


<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site de Recettes - Page modification de recettes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="d-flex flex-column min-vh-100">
    <div class="container">
        <?php require_once(__DIR__ . '/header.php'); ?>
        <h1>Modifier la recette</h1>
        <form action="recipes_post_update.php" method="POST">
            <div class="mb-3 visually-hidden">
                <label for="id" class="form-label">Identifiant de la recette</label>
                <input type="hidden" class="form-control" id="id" name="id" value="<?php echo $id; ?>">
            </div>
            <div class="mb-3">
                <label for="title" class="form-label">Titre de la recette</label>
                <input type="text" class="form-control" id="title" name="title" aria-describedby="title-help">
                <div id="title-help" class="form-text">Choisisez un titre percutant !</div>
            </div>
            <div class="mb-3">
                <label for="recipe" class="form-label">Description de la recette</label>
                <textarea class="form-control" placeholder="Seulement du contenu vous appartenant ou libre de droits" id="recipe" name="recipe"></textarea>
            </div>
        
            <button type="submit" class="btn btn-primary">Envoyer</button>
        </form>
        <br />
    </div>
    <?php require_once(__DIR__ . '/footer.php'); ?>
</body>


</html>