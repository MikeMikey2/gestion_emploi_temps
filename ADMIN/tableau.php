<?php
session_start();
include_once "con_dbb.php";
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
      <div class="Gtitre"><b>AFFICHAGE DU TABLEAU DE BORD</b></div>
      <nav>
              <h5 class="menu">MENU</h5>
         <ul class="nav-list">
            <li><a href="tableau.php" class="<?= (basename($_SERVER['PHP_SELF'])=='tableau.php') ? 'nav-active' : '' ?>"><img src="../icons/table.png" alt="20" width="30">Tableau de bord</a></li>
            <li><a href="Gestion.php" class="<?= (basename($_SERVER['PHP_SELF'])=='Gestion.php') ? 'nav-active' : '' ?>"><img src="../icons/per.png" alt="20" width="30">Gestion</a></li>
            <li><a href="Emploi.php" class="<?= (basename($_SERVER['PHP_SELF'])=='Emploi.php') ? 'nav-active' : '' ?>"><img src="../icons/evenement.png" alt="20" width="30"> Emploi du temps</a></li>
            <li><a href="Requetes.php" class="<?= (basename($_SERVER['PHP_SELF'])=='Requetes.php') ? 'nav-active' : '' ?>"><img src="../icons/message.jpeg" alt="20" width="30">Requetes<span class="badge"><?php echo mysqli_num_rows(mysqli_query($con, "SELECT * FROM REQUETE WHERE statut='en_attente'")); ?></span></a></li>
        </ul>
    </nav>
    <section>
        <h1>Tableau de bord</h1>
        <div class="choix">
            <p>tableau de bord</p>
          <div class="container"> 
            <div class="nbprof">
                <h2> Utilisateurs</h2>
                <h4><span>
                    <?php
                        // Requête pour compter le nombre total de personnes
                        $sql = "SELECT COUNT(*) AS nombre_personnes FROM PERSONNE";
                        $result = $con->query($sql);

                              if ($result) { 
                                $row = $result->fetch_assoc();
                                 echo $row['nombre_personnes'];
                              } else {
                                echo "Erreur lors de l'exécution de la requête : " . $con->error;
                              }
                    ?>
                    </span>
                </h4>
                <div class="nb">
                    <p><a href="">Voir les details</a></p>
                    
                </div>
            </div>
            <div class="nbclass">
                   <h2>Cours actifs</h2>
                <h4><span><?php
                        // Requête pour compter le nombre total de personnes
                        $sql2 = "SELECT COUNT(*) AS nombre_cours FROM COURS";
                        $result = $con->query($sql2);

                              if ($result) { 
                                $row = $result->fetch_assoc();
                                 echo $row['nombre_cours'];
                              } else {
                                echo "Erreur lors de l'exécution de la requête : " . $con->error;
                              }
                    ?></span></h4>
                <div class="nb">
                    <p><a href="">Voir les details</a></p>
            </div>
           </div>  
             <div class="nbsalles">
                   <h2>Creneaux cette semaine</h2>
                <h4>
                    <span>
                        <?php
                        // Requête pour compter le nombre total de personnes
                        $sql3 = "SELECT COUNT(*) AS nombre_creneau FROM CRENEAU";
                        $result = $con->query($sql3);

                              if ($result) { 
                                $row = $result->fetch_assoc();
                                 echo $row['nombre_creneau'];
                              } else {
                                echo "Erreur lors de l'exécution de la requête : " . $con->error;
                              }
                    ?>
                    </span>
                </h4>
                <div class="nb">
                    <p><a href="">Voir les details</a></p>
            </div>
        </div>
          <div class="emploi">
                   <h2>Requetes en attentes</h2>
                <h4>
                    <span >
                        <?php
                        // Requête pour compter le nombre total de personnes
                        $sql4 = "SELECT COUNT(*) AS nombre_requete FROM REQUETE";
                        $result = $con->query($sql4);

                              if ($result) { 
                                $row = $result->fetch_assoc();
                                 echo $row['nombre_requete'];
                              } else {
                                echo "Erreur lors de l'exécution de la requête : " . $con->error;
                              }
                    ?>
                    </span>
                </h4>
                <div class="nb">
                    <p><a href="">Voir les details</a></p>
            </div>
            
    </section>
</body>
</html>