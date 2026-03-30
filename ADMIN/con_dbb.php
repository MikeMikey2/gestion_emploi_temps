<?php
$con=mysqli_connect("localhost","phpmyadmin","mbele2.0","emploi");
if(!$con) die('Erreur :'.mysqli_connect_error());
mysqli_set_charset($con, "utf8mb4");
?>