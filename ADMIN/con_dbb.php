<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);
$con = mysqli_connect("localhost", "root", "", "emploi");
if (!$con) die('Erreur de connexion : ' . mysqli_connect_error());
mysqli_set_charset($con, "utf8mb4");
?>