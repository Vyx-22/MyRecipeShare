<?php session_start(); ?>
<?php require_once(__DIR__ . '/variables.php'); 
require_once(__DIR__ . '/functions.php');

$id = $_GET['id'];

if (!isset($id) || !is_numeric($id)) {
    echo 'Il faut un identifiant de recette valide pour la consulter.';
    return;
}

$readRecipeStatement = $mysqlClient->prepare('SELECT * FROM recipes WHERE recipe_id = :id');
$readRecipeStatement->execute([
    'id' => $id,
]);
$recipe = $readRecipeStatement->fetch(PDO::FETCH_ASSOC);

//-----------------------NOTE---------------
if (isset($_POST['note'])) {
   $insertnote = $mysqlClient->prepare('UPDATE comments SET review = :note WHERE recipe_id = :id');
    $insertnote->execute([
    'note' => $_POST['note'],
    'id' => $id,
    ]);
}
    $sqlQuery = 'SELECT ROUND(AVG(c.review),1) as rating FROM recipes r LEFT JOIN comments c on r.recipe_id = c.recipe_id WHERE r.recipe_id = :id';
    $averageRatingStatment = $mysqlClient->prepare($sqlQuery);
    $averageRatingStatment->execute(['id' => $id,]);
    $moyenne_note = $averageRatingStatment->fetch();

    $note_affiche = ($moyenne_note && $moyenne_note['rating'] !== null) 
    ? $moyenne_note['rating'] 
    : 'Pas encore de note';



//-------------------------COMMENTAIRE-------------------------
$sqlQuery = 'SELECT u.full_name, c.comment, r.title, DATE_FORMAT(c.created_at, "%d/%m/%Y") AS comment_date
FROM users u
JOIN comments c
    ON u.user_id = c.user_id
JOIN recipes r
    ON c.recipe_id = r.recipe_id
WHERE r.recipe_id = :id
ORDER BY c.created_at DESC
LIMIT 10'
;

$commentRecipeStatement = $mysqlClient->prepare($sqlQuery);
$commentRecipeStatement->execute([
    'id' => $id,
]);

$comments = $commentRecipeStatement->fetchAll(PDO::FETCH_ASSOC);

?> 
<!DOCTYPE html>
<html>


<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site de Recettes - Page affichage des détails d'une recette</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="d-flex flex-column min-vh-100">
    <div class="container">
        <div class="mb-3"> 
            <?php require_once(__DIR__ . '/header.php'); ?>
            <h2>Details de la recette</h2>
                    <article>
                        <h4><?php echo $recipe['title'] . " (" . $note_affiche . "⭐)"; ?></h4>
                                    
                        <div><?php echo $recipe['recipe']; ?></div>
                        <i><?php echo displayAuthor($recipe['author'], $users); ?></i>
                    </article>
            <br />
        </div>

        
        <div class="mb-3">
            <h3><?php echo "Commentaires"; ?></h3>
            <?php  
                if (count($comments) > 0) {
                    foreach ($comments as $comment) {
                        echo $comment['full_name'] . " : " . $comment['comment']. "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . "<i>".$comment['comment_date']."</i>";
                    }
                } else {
                    echo "Aucun commentaire";
                }
        
            ?>
            </br></br> </br>
        </div>

        <!---------FORMULAIRE DE COMMENTAIRES---------->
        <?php if (isset($_SESSION['LOGGED_USER'])): ?>
            <form action="comments_treat.php" method="POST" >
                <div class="mb-3 visually-hidden">
                    <label for="id" class="form-label">Identifiant de la recette</label>
                    <input type="hidden" name="id" value="<?= $id ?>">
                </div>
                <div class="mb-3">
                    <label for="comment" class="form-label">Réagir à cette recette</label>
                    <textarea class="form-control" placeholder="Ajouter un commentaire..." id="comment" name="comment"></textarea>
        
                </div>
                <button type="submit" class="btn btn-primary">Commenter</button>
        
            </form>
            </br></br> </br>

            <div class="mb-3">
                <form action=" " method="POST">
                    
                    <label for="note"><h4><?php echo "Notez cette recette : "; ?></h4></label>
                    <input type="number" id="note" name="note" min="1" max="5" required>
                    <button type="submit" class="btn btn-primary">Envoyer</button>
                
                </form>
             </div>
        <?php endif ?>
    </div>
    <?php require_once(__DIR__ . '/footer.php'); ?>
</body>


</html>