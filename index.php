<?php
if(isset($_POST['connected'])){
    header("Location: connect.php");
    exit();
}
if(isset($_POST['registered'])){
    header("Location: inscr.php");
    exit();
}
// Redirection directe vers la page de connexion
header("Location: connect.php");
exit();
?>