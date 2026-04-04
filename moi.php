<?php
$mdp = "mk"; // ← mettez le mot de passe souhaité
$hash = password_hash($mdp, PASSWORD_DEFAULT);
echo $hash;
?>