<?php require_once(__DIR__ . '/databaseconnect.php'); ?>
<?php

$sqlQuery1 = 'SELECT * FROM users';
$usersStatement = $mysqlClient->prepare($sqlQuery1);
$usersStatement->execute();
$users = $usersStatement->fetchAll();

$sqlQuery2 = 'SELECT * FROM recipes';
$recipesStatement = $mysqlClient->prepare($sqlQuery2);
$recipesStatement->execute();
$recipes = $recipesStatement->fetchAll();

?>