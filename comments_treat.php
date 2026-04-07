<?php session_start(); ?>
<?php
require_once(__DIR__ . '/isConnect.php');
require_once(__DIR__ . '/variables.php');
require_once(__DIR__ . '/login.php');
?>

<?php

if(!isset($_POST['comment']) ||
!isset($_POST['id' ]) ||
 empty(trim($_POST['comment'])))

{
    echo "Le champ du commentaire est vide";
    return;
}

$comment = htmlspecialchars($_POST['comment']); 
$recipe_id = $_POST['id'];
$user_id = $_SESSION['LOGGED_USER']['user_id'];

$insertcomment = $mysqlClient->prepare('INSERT INTO comments(user_id,recipe_id,comment) VALUES (:user_id, :recipe_id, :comment)');
$insertcomment->execute([
    'user_id' => $user_id,
    'recipe_id' => $recipe_id,
    'comment' => $comment,
    
    ]);
?>
    
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site de Recettes - commentaire ajouté</title>
    <link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
rel="stylesheet"
>
</head>

<body>
    <div class="container">
        <?php require_once(__DIR__ . '/header.php'); ?>
        <h1>Commentaire ajouté avec succès! ✅</h1>
        <div class="card">
        <div class="card-body">
            <h5 class="card-title"><?php echo 'Votre commentaire :'; ?></h5>
            <p class="card-text"><?php echo $comment; ?></p>
          
        
        </div>
    </div>
    <?php require_once(__DIR__ . '/footer.php'); ?>
</body>
</html>

