<?php
include_once"con_dbb.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>classe</title>
    <link rel="stylesheet" href="style/style.css">
</head>
<body>
    <div class="Gtitre"><b>GESTION DE L'EMPLOI DU TEMPS</b></div>
      <nav>
             <h5 class="menu">MENU</h5>
            <ul class="nav-list">
              <li><a href="tableau.php" class="<?= (basename($_SERVER['PHP_SELF'])=='tableau.php') ? 'nav-active' : '' ?>"><img src="icons/tableau.png" alt="20" width="30">Tableau de bord</a></li>
            <li><a href="Professeurs.php" class="<?= (basename($_SERVER['PHP_SELF'])=='Professeurs.php') ? 'nav-active' : '' ?>"><img src="icons/prof.png" alt="20" width="30">Professeurs</a></li>
            <li><a href="salle.php" class="<?= (basename($_SERVER['PHP_SELF'])=='salle.php') ? 'nav-active' : '' ?>"><img src="icons/salle.png" alt="20" width="30"> Salles</a></li>
            <li><a href="classe.php" class="<?= (basename($_SERVER['PHP_SELF'])=='classe.php') ? 'nav-active' : '' ?>"><img src="icons/classe.png" alt="20" width="30"><u>Classes</u></a></li>
            <li><a href="Emploi.php" class="<?= (basename($_SERVER['PHP_SELF'])=='Emploi.php') ? 'nav-active' : '' ?>"><img src="icons/emp.png" alt="20" width="30"> Emploi du temps</a></li>
          </ul>
    </nav>
</body>
</html>