<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'etudiant') {
    header("Location: ../index.php");
    exit;
}
include_once "../ADMIN/con_dbb.php";
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
                    <span>📍 Salle <?= htmlspecialchars($row['salle'] ?? '') ?></span>
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
    <title>Appli</title>
    <link rel="stylesheet" href="../style/style2.css">
</head>
<body>
<div class="Gtitre"><b>GESTION DE L'EMPLOI DU TEMPS</b></div>
<nav>
    <h5 class="menu">MENU</h5>
    <ul class="nav-list">
        <li><a href="Emploi.php" class="<?= (basename($_SERVER['PHP_SELF']) == 'Emploi.php') ? 'nav-active' : '' ?>">
            <img src="../icons/evenement.jpeg" alt="" width="30"> Emploi du temps</a></li>
        <li><a href="Lessons.php" class="<?= (basename($_SERVER['PHP_SELF']) == 'Lessons.php') ? 'nav-active' : '' ?>">
            <img src="../icons/e.png" alt="" width="30"> Leçons</a></li>
    </ul>
    <ul class="nav-footer">
        <li><a href="../logout.php">
            <img src="../icons/back.png" alt="" width="30"> Déconnexion</a></li>
    </ul>
</nav>
<section>
    <div class="dashboard-container">
        <main class="main-content full-width">
            <div class="section-header">
                <h1>Mon emploi du temps</h1>
            </div>
            <div class="week-schedule">
                <?php
                // 1. Préparation — vérification immédiate
                $stmt = $con->prepare("SELECT c.*, co.code_cours, co.description, c.salle FROM CRENEAU c JOIN COURS co ON c.id_cours = co.id_cours WHERE c.filiere = ? ORDER BY c.date, c.heure_debut");
                if (!$stmt) {
                    die("Erreur de préparation : " . $con->error);
                }

                // 2. Liaison et exécution
                $stmt->bind_param("s", $filiere);
                if (!$stmt->execute()) {
                    die("Erreur d'exécution : " . $stmt->error);
                }
                $result = $stmt->get_result();
                $found = false;

                while ($row = $result->fetch_assoc()) {
                    $found = true;
                    emploi_info($row);
                }

                // 4. Message si aucun créneau trouvé
                if (!$found) {
                    echo '<p class="no-data">Aucun créneau trouvé pour votre filière.</p>';
                }

                $stmt->close();
                ?>
            </div>
        </main>
    </div>
</section>
</body>
</html>