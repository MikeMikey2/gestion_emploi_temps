<?php
session_start();
include_once "ADMIN/con_dbb.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau</title>
    <link rel="stylesheet" href="../style/style2.css">
</head>
<body>
      <div class="Gtitre"><b>GESTION DE L'EMPLOI DU TEMPS</b></div>
      <nav>
              <h5 class="menu">MENU</h5>
                    <ul class="nav-list">
                            <li><a href="tableau.php" class="<?= (basename($_SERVER['PHP_SELF'])=='tableau.php') ? 'nav-active' : '' ?>"><img src="icons/tableau.png" alt="20" width="30"><u>Tableau de bord</u></a></li>
                        <li><a href="Professeurs.php" class="<?= (basename($_SERVER['PHP_SELF'])=='Professeurs.php') ? 'nav-active' : '' ?>"><img src="icons/prof.png" alt="20" width="30">Professeurs</a></li>
                        <li><a href="salle.php" class="<?= (basename($_SERVER['PHP_SELF'])=='salle.php') ? 'nav-active' : '' ?>"><img src="icons/salle.png" alt="20" width="30"> Salles</a></li>
                        <li><a href="classe.php" class="<?= (basename($_SERVER['PHP_SELF'])=='classe.php') ? 'nav-active' : '' ?>"><img src="icons/classe.png" alt="20" width="30"> Classe</a></li>
                        <li><a href="Emploi.php" class="<?= (basename($_SERVER['PHP_SELF'])=='Emploi.php') ? 'nav-active' : '' ?>"><img src="icons/emp.png" alt="20" width="30">Emploi du temps</a></li>
                        <li><a href="Inscription.php" class="<?= (basename($_SERVER['PHP_SELF'])=='Inscription.php') ? 'nav-active' : '' ?>"><img src="icons/inscription.jpeg" alt="20" width="30">Inscription</a></li>
                </ul>
    </nav>
    <section>
        <h1>Tableau de bord</h1>
        <div class="choix">
            <p>tableau de bord</p>
          <div class="container"> 
            <div class="nbprof">
                <h2>Les professeurs</h2>
                <h4>2</h4>
                <div class="nb">
                    <p><a href="Professeurs.php">Voir les details</a></p>
                    
                </div>
            </div>
            <div class="nbclass">
                   <h2>Les classes</h2>
                <h4>3</h4>
                <div class="nb">
                    <p><a href="">Voir les details</a></p>
            </div>
           </div>  
             <div class="nbsalles">
                   <h2>Les salles</h2>
                <h4>3</h4>
                <div class="nb">
                    <p><a href="">Voir les details</a></p>
            </div>
        </div>
          <div class="emploi">
                   <h2>L'emploi du temps</h2>
                <h4>2</h4>
                <div class="nb">
                    <p><a href="">Voir les details</a></p>
            </div>
    </section>
    <section>
        <?php
        $stm=mysqli_query($con," SELECT * FROM Etudiants");
        $stud=$stm->fetch_all(MYSQLI_ASSOC);
        ?>
        <table>
            <tr>
                <th>NumEtudiant</th>
            <th>Nom</th>
            <th>Prenom</th>
            <th>Classe</th>
            <th>Genre</th>
            </tr>
            <?php
            foreach($stud as $st):
            ?>
            <tr>
               <td><?= htmlspecialchars($st['id_etudiant'])?></td>
               <td><?= htmlspecialchars($st['nom'])?></td>
               <td><?= htmlspecialchars($st['prenom'])?></td>
               <td><?= htmlspecialchars($st['classe'])?></td>
               <td><?= htmlspecialchars($st['sexe'])?></td>
            </tr>
            <?php
            endforeach;
            ?>
        </table>
    </section>
</body>
</html>