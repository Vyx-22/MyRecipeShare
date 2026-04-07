<?php session_start(); ?>

<?php require_once(__DIR__ . '/functions.php'); ?>

<?php 
session_unset();
session_destroy(); 

redirectToUrl ('index.php');
?>