<?php require_once(__DIR__ . '/config/mysql.php'); ?>

<?php
try
{
    $mysqlClient = new PDO(
        "mysql:host=$nom_hote;dbname=$nom_base;charset=utf8",
        $nom_utilisateur,
        $mot_de_passe
    );
}
catch (Exception $e)
{
    die('Erreur : ' . $e->getMessage());
}
?>