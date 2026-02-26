<?php

session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'enseignant') { header("Location: ../index.php"); exit; }
include_once "../ADMIN/con_dbb.php";
$id = $_SESSION['id_personne'];
if(isset($_POST['btn'])){
    header("Location: rediger.php");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appli</title>
    <link rel="stylesheet" href="../style/style2.css">
</head>
<body>
    <div class="Gtitre"><b>GESTION DE L'EMPLOI DU TEMPS</b></div>
      <nav>
     <h5 class="menu">MENU</h5>
         <ul class="nav-list">
            <li><a href="Emploi.php" class="<?= (basename($_SERVER['PHP_SELF'])=='Emploi.php') ? 'nav-active' : '' ?>"><img src="../icons/evenement.png" alt="20" width="30"> Emploi du temps</a></li>
            <li><a href="Requetes.php" class="<?= (basename($_SERVER['PHP_SELF'])=='Requetes.php') ? 'nav-active' : '' ?>"><img src="../icons/message.jpeg" alt="20" width="30">Requetes <span class="badge"><?php echo mysqli_num_rows(mysqli_query($con, "SELECT * FROM REQUETE WHERE statut='acceptée' OR statut='refusée'")); ?></span></a></li>
            <li><a href="Leçons.php" class="<?= (basename($_SERVER['PHP_SELF'])=='Leçons.php') ? 'nav-active' : '' ?>"><img src="../icons/leçon.png" alt="20" width="30">Leçons</a></li>
            <li><a href="../logout.php" class="<?= (basename($_SERVER['PHP_SELF'])=='../logout.php') ? 'nav-active' :'' ?>"><img src="../icons/back.jpeg" alt="20" width="30">Deconnexion</a></li>
        </ul>
    </nav>
    <section>
        <div class="dashboard-container">
            <main class="main-content full-width">
                <div class="section-header">
                    <h1>Mon emploi du temps</h1>
                    <form action="#" method="POST">
                        <button class=" btn-primary" name="btn" id="newRequestBtn">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                            <path d="M10 4v12m-6-6h12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                        <span>Nouvelle requête</span>
                    </button>
                    </form>
                </div>
                
                <div class="week-schedule">
                    <div class="week-day">
                        <?php
                          function emploi_info($row){
                         ?>
                        <div class="day-header">
                            
                            <span><?= htmlspecialchars($row['date']??'') ?></span>
                        </div>
                        <div class="day-slots">
                            <div class="time-slot">
                                <div class="slot-time"><?= htmlspecialchars($row['heure_debut']??'') ?> - <?= htmlspecialchars($row['heure_fin']??'') ?></div>
                                <div class="slot-card">
                                    <h4><?= htmlspecialchars($row['code_cours']??'') ?></h4>
                                    <p><?= htmlspecialchars($row['description']??'') ?></p>
                                    <div class="slot-meta">
                                        <span>📍 Salle <?= htmlspecialchars($row['salle']??'') ?></span>
                                        <span><?=htmlspecialchars($row['filiere'])?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                            <?php 
                 }
                    $stmt = $con->prepare("SELECT c.*, co.code_cours, co.description FROM CRENEAU c JOIN COURS co ON c.id_cours = co.id_cours WHERE c.id_personne = ? ORDER BY c.date, c.heure_debut");
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $res = $stmt->get_result();
                while($row = $res->fetch_assoc()){
                       emploi_info($row);
                }
                ?>
                    </div>
                </div>
            </main>
        </div>

    </section>
        
</body>
</html>