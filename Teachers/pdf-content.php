<?php
session_start();
$title      = $_SESSION['lecon_title']    ?? '';
$corp       = $_SESSION['lecon_corp']     ?? '';
$code_cours = $_SESSION['lecon_id_cours'] ?? '';
include_once "../ADMIN/con_dbb.php";
$id = (int)$_SESSION['id_personne'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contenu PDF</title>
    <link rel="stylesheet" href="../style/style2.css">
</head>
<body>
    <div class="Gtitre"><b>GESTION DE L'EMPLOI DU TEMPS</b></div>
      <nav>
     <h5 class="menu">MENU</h5>
         <ul class="nav-list">
            <li><a href="Emploi.php" class="<?= (basename($_SERVER['PHP_SELF'])=='Emploi.php') ? 'nav-active' : '' ?>"><img src="../icons/evenement.png" alt="20" width="30"> Emploi du temps</a></li>
            <li><a href="Requetes.php" class="<?= (basename($_SERVER['PHP_SELF'])=='Requetes.php') ? 'nav-active' : '' ?>"><img src="../icons/message.jpeg" alt="20" width="30">Requetes <span class="badge"><?php echo mysqli_num_rows(mysqli_query($con, "SELECT r.* FROM REQUETE r JOIN PERSONNE p ON r.id_personne = p.id_personne WHERE (r.statut='acceptée' OR r.statut='refusée') AND r.id_personne=$id")); ?></span></a></li>
            <li><a href="Leçons.php" class="<?= (basename($_SERVER['PHP_SELF'])=='Leçons.php') ? 'nav-active' : '' ?>"><img src="../icons/prof.png" alt="20" width="30">Leçons</a></li>
            <li><a href="../logout.php" class="<?= (basename($_SERVER['PHP_SELF'])=='../logout.php') ? 'nav-active' :'' ?>"><img src="../icons/back.jpeg" alt="20" width="30">Deconnexion</a></li>
        </ul>
    </nav>
    <section>
       
        <div class="pdf-content">
            <h2>Leçon 1: <?= htmlspecialchars($title) ?></h2>
            <p><strong>Code du cours:</strong> <?= htmlspecialchars($code_cours) ?></p>
            <p><strong>Filière:</strong> <?= htmlspecialchars($filiere ?? 'Non spécifiée') ?></p>
            <hr>
            <div class="lesson-body">
                <?= htmlspecialchars_decode($corp) ?>
            </div>
                
</body>
</html>