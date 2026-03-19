<?php
if(isset($_POST['connected'])){
    header("Location: connect.php");
    exit();
}
if(isset($_POST['registered'])){
    header("Location: inscr.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion Emploi du Temps</title>
    <link rel="stylesheet" href="style/style2.css">
</head>
<body>
    <section>
        <div class="container">
            <h1>Bienvenue sur notre application de gestion d'emploi du temps</h1>
            <p>Veuillez vous connecter pour accéder à votre emploi du temps personnalisé.</p>
            <form action="#" method="post">
                <button name="connected" type="submit">Se connecter</button>
                <button name="registered" type="submit">S'inscrire</button>
            </form>
        </div>
    </section>
</body>
</html>