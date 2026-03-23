<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
include_once "con_dbb.php";
// verification des salles qui  sont disponibles

$stmt = $con->prepare("SELECT * FROM SALLE WHERE disponible = 1");
$stmt->execute();
$result = $stmt->get_result();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../style/style2.css">
</head>
<body>
    <div class="Gtitre"><b>Salles disponibles</b></div>
      <nav>
     <h5 class="menu">MENU</h5>
         <ul class="nav-list">
            <li><a href="tableau.php" class="<?= (basename($_SERVER['PHP_SELF'])=='tableau.php') ? 'nav-active' : '' ?>"><img src="../icons/table.png" alt="20" width="30">Tableau de bord</a></li>
            <li><a href="Gestion.php" class="<?= (basename($_SERVER['PHP_SELF'])=='Gestion.php') ? 'nav-active' : '' ?>"><img src="../icons/gest.png" alt="20" width="30">Gestion</a></li>
            <li><a href="Emploi.php" class="<?= (basename($_SERVER['PHP_SELF'])=='Emploi.php') ? 'nav-active' : '' ?>"><img src="../icons/evenement.jpeg" alt="20" width="30">Emploi du temps</a></li>
            <li><a href="Requetes.php" class="<?= (basename($_SERVER['PHP_SELF'])=='Requetes.php') ? 'nav-active' : '' ?>"><img src="../icons/request.png" alt="20" width="30">Requetes<span class="badge"><?php echo mysqli_num_rows(mysqli_query($con, "SELECT * FROM REQUETE WHERE statut='en_attente'")); ?></span></a></li>
            <li><a href="profdispo.php" class="<?= (basename($_SERVER['PHP_SELF'])=='profdispo.php') ? 'nav-active' : '' ?>"><img src="../icons/dispo.png" alt="20" width="30">Enseignants disponibles</a></li>
            <li><a href="salles_dispo.php" class="<?= (basename($_SERVER['PHP_SELF'])=='salles_dispo.php') ? 'nav-active' : '' ?>"><img src="../icons/sall.jpeg" alt="20" width="30">Salles disponibles</a></li>
        </ul>
        <ul class="nav-footer">
            <li><a href="../logout.php" class="<?= (basename($_SERVER['PHP_SELF'])=='../logout.php') ? 'nav-active' :'' ?>"><img src="../icons/back.png" alt="20" width="30">Deconnexion</a></li>
        </ul>
    </nav>
    <?php foreach($result as $row) { ?>
    <div class="prof-container">
        <section class="prof">
        <p><strong>Nom:</strong> <?= htmlspecialchars($row['nom_salle'] ?? '') ?></p>
        <p><strong>Capacité:</strong> <?= htmlspecialchars($row['capacité'] ?? '') ?></p>
        <p><strong>Jour:</strong> <?= htmlspecialchars($row['jour'] ?? '') ?></p>
         <p><strong>Disponibilité:</strong> <?= ($row['disponible'] == 1) ? 'Disponible' : 'Indisponible' ?></p>
         <p><strong>Heure de début:</strong> <?= htmlspecialchars($row['heure_debut'] ?? '') ?></p>
         <p><strong>Heure de fin:</strong> <?= htmlspecialchars($row['heure_fin'] ?? '') ?></p>
    </section>
    </div>
    <?php
}
$stmt->close();
?>
</body>
</html>