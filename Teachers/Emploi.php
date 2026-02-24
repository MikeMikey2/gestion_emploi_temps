<?php

session_start();
include_once "../ADMIN/con_dbb.php";
$id = isset($_GET['id']) ? $_GET['id'] : (isset($_POST['id']) ? $_POST['id'] : null);

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
    <div ><b>GESTION DE L'EMPLOI DU TEMPS</b></div>
      <nav>
     <h5 class="menu">MENU</h5>
         <ul class="nav-list">
            <li><a href="Professeurs.php" class="<?= (basename($_SERVER['PHP_SELF'])=='Professeurs.php') ? 'nav-active' : '' ?>"><img src="icons/prof.png" alt="20" width="30">Professeurs</a></li>
            <li><a href="Emploi.php" class="<?= (basename($_SERVER['PHP_SELF'])=='Emploi.php') ? 'nav-active' : '' ?>"><img src="icons/emp.png" alt="20" width="30"> Emploi du temps</a></li>
        </ul>
    </nav>
    <section>
        <div class="dashboard-container">
            <main class="main-content full-width">
                <div class="section-header">
                    <h1>Mon emploi du temps</h1>
                    <button class=" btn-primary" id="newRequestBtn">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                            <path d="M10 4v12m-6-6h12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                        <span>Nouvelle requête</span>
                    </button>
                </div>
                <?php
                $stmt = $con->prepare("SELECT * FROM CRENEAU WHERE id_personne=(SELECT id_personne FROM PERSONNE WHERE email=? AND enseignant=1)");
                $stmt->bind_param("s", $_SESSION['email']);
                $stmt->execute();
                $res = $stmt->get_result();
                while($row = $res->fetch_assoc()):
                
                ?>
                <div class="week-schedule">
                    <div class="week-day">
                        <div class="day-header">
                            <span><?= htmlspecialchars($row['date']) ?></span>
                        </div>
                        <div class="day-slots">
                            <div class="time-slot">
                                <div class="slot-time"><?= htmlspecialchars($row['heure_debut']) ?> - <?= htmlspecialchars($row['heure_fin']) ?></div>
                                <div class="slot-card">
                                    <h4><?= htmlspecialchars($row['code_cours']) ?></h4>
                                    <p><?= htmlspecialchars($row['description']) ?></p>
                                    <div class="slot-meta">
                                        <span>📍 Salle <?= htmlspecialchars($row['salle']) ?></span>
                                        <span>👥 <?php  
                                        $stmt2 = $con->prepare("SELECT COUNT(*) as count FROM PERSONNE WHERE enseignant=0 AND id_creneau=?");
                                        $stmt2->bind_param("i", $row['id_personne']);
                                        $stmt2->execute();
                                        $res2 = $stmt2->get_result();
                                        echo htmlspecialchars($res2->fetch_assoc()['count']);
                                        ?> étudiants</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </main>
                </div>
                    <?php 
                    $stmt->close();
                    endwhile 
                    ?>
    </section>
        
</body>
</html>