<?php
include_once "../ADMIN/con_dbb.php";
// verification des enseignants qui n'ont sont disponibles
session_start();


$stmt = $con->prepare("SELECT d.*,p.nom,p.prenom FROM DISPONIBILITE d JOIN PERSONNE p ON d.id_personne = p.id_personne WHERE p.enseignant = 1  ORDER BY d.date, d.heure");
$stmt->bind_param("i", $_SESSION['id_personne']);
$stmt->execute();
$result = $stmt->get_result();
foreach($result as $row) {

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
    <div class="Gtitre"><b>GESTION DE L'EMPLOI DU TEMPS</b></div>
      <nav>
     <h5 class="menu">MENU</h5>
         <ul class="nav-list">
            <li><a href="tableau.php" class="<?= (basename($_SERVER['PHP_SELF'])=='tableau.php') ? 'nav-active' : '' ?>"><img src="../icons/table.png" alt="20" width="30">Tableau de bord</a></li>
            <li><a href="Gestion.php" class="<?= (basename($_SERVER['PHP_SELF'])=='Gestion.php') ? 'nav-active' : '' ?>"><img src="../icons/per.png" alt="20" width="30">Gestion</a></li>
            <li><a href="Emploi.php" class="<?= (basename($_SERVER['PHP_SELF'])=='Emploi.php') ? 'nav-active' : '' ?>"><img src="../icons/evenement.png" alt="20" width="30">Emploi du temps</a></li>
            <li><a href="Requetes.php" class="<?= (basename($_SERVER['PHP_SELF'])=='Requetes.php') ? 'nav-active' : '' ?>"><img src="../icons/message.jpeg" alt="20" width="30">Requetes<span class="badge"><?php echo mysqli_num_rows(mysqli_query($con, "SELECT * FROM REQUETE WHERE statut='en_attente'")); ?></span></a></li>
            <li><a href="profdispo.php" class="<?= (basename($_SERVER['PHP_SELF'])=='profdispo.php') ? 'nav-active' : '' ?>"><img src="../icons/calendar.png" alt="20" width="30">Enseignants disponibles</a></li>
            <li><a href="../logout.php" class="<?= (basename($_SERVER['PHP_SELF'])=='../logout.php') ? 'nav-active' :'' ?>"><img src="../icons/back.jpeg" alt="20" width="30">Deconnexion</a></li>
        </ul>
    </nav>
    <section>
        <h1>Disponibilité</h1>
        <p><strong>Nom:</strong> <?= htmlspecialchars($row['nom'] ?? '') ?></p>
        <p><strong>Prénom:</strong> <?= htmlspecialchars($row['prenom'] ?? '') ?></p>   
        <p><strong>Date:</strong> <?= htmlspecialchars($row['date'] ?? '') ?></p>
        <p><strong>Heure dispo:</strong> <?= htmlspecialchars($row['heure']) ?? '' ?></p>
    </section>
    <?php
}
$stmt->close();
?>
</body>
</html>