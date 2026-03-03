<?php
session_start();
include_once "../ADMIN/con_dbb.php";
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
        <?php
        $str= mysqli_query($con, "SELECT l.*,c.code_cours,c.description FROM LEÇON l JOIN COURS c ON l.id_cours = c.id_cours WHERE l.id_cours =$id_cours");
        if($str && mysqli_num_rows($str) > 0){
            while($row = mysqli_fetch_assoc($str)){
                emploi_info($row);
            }
        } 
        ?>
        <div class="pdf-content">
            <h2>Leçon 1: <?= $row['titre'] ?></h2>
            <p><strong>Code du cours:</strong> <?= $row['code_cours'] ?></p>
            <p><strong>Description:</strong> <?= $row['description'] ?></p>
            <p><strong>Filière:</strong> <?= $row['filiere'] ?></p>
            <hr>
            <div class="lesson-body">
                <?= nl2br(htmlspecialchars($row['corp'])) ?>
            </div>
                
</body>
</html>