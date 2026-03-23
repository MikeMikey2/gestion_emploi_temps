<?php
session_start(); // ← manquant !
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'etudiant') { 
    header("Location: ../index.php"); 
    exit; 
}
include_once "../ADMIN/con_dbb.php";
$filiere = $_SESSION['filiere'];
if(isset($_POST['generate_pdf'])) {
    header("Location: ../Teachers/genpdf.php");
    exit();
}
if(isset($_POST['view'])) {
    header("Location: ../Teachers/pdf-content.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cours</title>
    <link rel="stylesheet" href="../style/style2.css">
</head>
<body>
    <div class="Gtitre"><b>GESTION DE L'EMPLOI DU TEMPS</b></div>
      <nav>
     <h5 class="menu">MENU</h5>
         <ul class="nav-list">
            <li><a href="Emploi.php" class="<?= (basename($_SERVER['PHP_SELF'])=='Emploi.php') ? 'nav-active' : '' ?>"><img src="../icons/evenement.jpeg" alt="20" width="30"> Emploi du temps</a></li>
            <li><a href="Lessons.php" class="<?= (basename($_SERVER['PHP_SELF'])=='Lessons.php') ? 'nav-active' : '' ?>"><img src="../icons/e.png" alt="20" width="30">Leçons</a></li>
        </ul>
        <ul class="nav-footer">
            <li><a href="../logout.php" class="<?= (basename($_SERVER['PHP_SELF'])=='../logout.php') ? 'nav-active' :'' ?>"><img src="../icons/back.png" alt="20" width="30">Deconnexion</a></li>
        </ul>
    </nav>
    <section>
        <h1>Mes leçons</h1>
        <p>Contenu des leçons à venir...</p>
        <form action="#" method="post">
            <button class="btn-primary" name="generate_pdf">Générer PDF</button>
        </form>
        <form action="#" method="POST">
            <button class="btn-primary" name="view">Voir les détails</button>
        </form>
    </section>
</body>
</html>