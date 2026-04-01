<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'etudiant') {
    header("Location: ../index.php");
    exit;
}
include_once "../ADMIN/con_dbb.php";
include_once "../icons/icons.php";
$filiere = $_SESSION['filiere'];

function emploi_info($row) {
?>
<div class="week-day">
    <div class="day-header">
        <span><?= htmlspecialchars($row['date'] ?? '') ?></span>
    </div>
    <div class="day-slots">
        <div class="time-slot">
            <div class="slot-time">
                <?= htmlspecialchars($row['heure_debut'] ?? '') ?> - <?= htmlspecialchars($row['heure_fin'] ?? '') ?>
            </div>
            <div class="slot-card">
                <h4><?= htmlspecialchars($row['code_cours'] ?? '') ?></h4>
                <p><?= htmlspecialchars($row['description'] ?? '') ?></p>
                <div class="slot-meta">
                    <span><?= svg_icon('salles', 16) ?> Salle <?= htmlspecialchars($row['salle'] ?? '') ?></span>
                    <span><?= htmlspecialchars($row['filiere'] ?? '') ?></span>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon emploi du temps</title>
    <link rel="stylesheet" href="../style/style2.css">
</head>
<body>
    <div class="Gtitre"><b>GESTION DE L'EMPLOI DU TEMPS</b></div>
    <nav>
        <button class="nav-toggle" id="navToggle" aria-label="Menu">
            <svg class="hamburger" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
            <svg class="close-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            <span>MENU</span>
        </button>
        <h5 class="menu"><?= svg_icon('menu', 14) ?> MENU</h5>
        <ul class="nav-list" id="navList">
            <li><a href="Emploi.php" class="<?= (basename($_SERVER['PHP_SELF'])=='Emploi.php') ? 'nav-active' : '' ?>"><?= svg_icon('emploi', 20) ?> Emploi du temps</a></li>
            <li><a href="Lessons.php" class="<?= (basename($_SERVER['PHP_SELF'])=='Lessons.php') ? 'nav-active' : '' ?>"><?= svg_icon('lesson', 20) ?>Leçons</a></li>
        </ul>
        <ul class="nav-footer" id="navFooter">
            <li><a href="../logout.php"><?= svg_icon('logout', 20) ?>Déconnexion</a></li>
        </ul>
    </nav>
    <section>
        <div class="dashboard-container">
            <main class="main-content full-width">
                <div class="section-header">
                    <h1>Mon emploi du temps</h1>
                    <p class="subtitle">Filière <?= htmlspecialchars($filiere) ?></p>
                </div>
                <div class="week-schedule">
                    <?php
                    $stmt = $con->prepare("SELECT c.*, co.code_cours, co.description, c.salle FROM CRENEAU c JOIN COURS co ON c.id_cours = co.id_cours WHERE c.filiere = ? ORDER BY c.date, c.heure_debut");
                    if ($stmt) {
                        $stmt->bind_param("s", $filiere);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $found = false;

                        while ($row = $result->fetch_assoc()) {
                            $found = true;
                            emploi_info($row);
                        }

                        if (!$found) {
                            echo '<p class="no-data">Aucun créneau trouvé pour votre filière.</p>';
                        }
                        $stmt->close();
                    } else {
                        echo '<p class="error">Erreur de préparation de la requête.</p>';
                    }
                    ?>
                </div>
            </main>
        </div>
    </section>

    <script>
    const navToggle = document.getElementById('navToggle');
    const navList   = document.getElementById('navList');
    const navFooter = document.getElementById('navFooter');

    if(navToggle) {
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
    }
    </script>
</body>
</html>