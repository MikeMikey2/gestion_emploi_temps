<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
include_once "con_dbb.php";
include_once "../icons/icons.php";

$stmt = $con->prepare("SELECT * FROM SALLE WHERE disponible = 1");
$stmt->execute();
$result = $stmt->get_result();

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salles disponibles</title>
    <link rel="stylesheet" href="../style/style2.css">
</head>
<body>
    <div class="Gtitre"><b>SALLES DISPONIBLES</b></div>
    <nav>
        <button class="nav-toggle" id="navToggle" aria-label="Menu">
            <svg class="hamburger" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
            <svg class="close-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            <span>MENU</span>
        </button>
        <h5 class="menu"><?= svg_icon('menu', 14) ?> MENU</h5>
        <ul class="nav-list" id="navList">
            <li><a href="tableau.php" class="<?= (basename($_SERVER['PHP_SELF'])=='tableau.php') ? 'nav-active' : '' ?>"><?= svg_icon('dashboard', 20) ?>Tableau de bord</a></li>
            <li><a href="Gestion.php" class="<?= (basename($_SERVER['PHP_SELF'])=='Gestion.php') ? 'nav-active' : '' ?>"><?= svg_icon('gestion', 20) ?>Gestion</a></li>
            <li><a href="Emploi.php" class="<?= (basename($_SERVER['PHP_SELF'])=='Emploi.php') ? 'nav-active' : '' ?>"><?= svg_icon('emploi', 20) ?>Emploi du temps</a></li>
            <li><a href="Requetes.php" class="<?= (basename($_SERVER['PHP_SELF'])=='Requetes.php') ? 'nav-active' : '' ?>"><?= svg_icon('requetes', 20) ?>Requêtes
                <span class="badge"><?php echo mysqli_num_rows(mysqli_query($con, "SELECT * FROM REQUETE WHERE statut='en_attente'")); ?></span>
            </a></li>
            <li><a href="profdispo.php" class="<?= (basename($_SERVER['PHP_SELF'])=='profdispo.php') ? 'nav-active' : '' ?>"><?= svg_icon('profdispo', 20) ?>Enseignants disponibles</a></li>
            <li><a href="salles_dispo.php" class="<?= (basename($_SERVER['PHP_SELF'])=='salles_dispo.php') ? 'nav-active' : '' ?>"><?= svg_icon('salles', 20) ?>Salles disponibles</a></li>
        </ul>
        <ul class="nav-footer" id="navFooter">
            <li><a href="../logout.php"><?= svg_icon('logout', 20) ?>Déconnexion</a></li>
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
<script>
    const navToggle = document.getElementById('navToggle');
    const navList   = document.getElementById('navList');
    const navFooter = document.getElementById('navFooter');

    navToggle.addEventListener('click', function () {
        const isOpen = navList.classList.contains('open');
        navList.classList.toggle('open', !isOpen);
        navFooter.classList.toggle('open', !isOpen);
        navToggle.classList.toggle('open', !isOpen);
    });

    navList.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', () => {
            navList.classList.remove('open');
            navFooter.classList.remove('open');
            navToggle.classList.remove('open');
        });
    });
</script>
</body>
</html>