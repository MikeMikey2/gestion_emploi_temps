<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'etudiant') { 
    header("Location: ../index.php"); 
    exit; 
}
include_once "../ADMIN/con_dbb.php";
include_once "../icons/icons.php";

$filiere = $_SESSION['filiere'];
$id_lecon = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$stmt = $con->prepare("SELECT l.*, c.code_cours FROM LEÇON l JOIN COURS c ON l.id_cours = c.id_cours WHERE l.id_leçon = ? AND l.filiere = ?");
if ($stmt) {
    $stmt->bind_param("is", $id_lecon, $filiere);
    $stmt->execute();
    $result = $stmt->get_result();
    $lesson = $result->fetch_assoc();
    $stmt->close();
}

if (!$lesson) {
    die("Leçon introuvable ou vous n'avez pas accès à cette leçon.");
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($lesson['titre']) ?> - Détails de la leçon</title>
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
            <li><a href="Emploi.php" class=""><?= svg_icon('emploi', 20) ?> Emploi du temps</a></li>
            <li><a href="Lessons.php" class="nav-active"><?= svg_icon('lesson', 20) ?>Leçons</a></li>
        </ul>
        <ul class="nav-footer" id="navFooter">
            <li><a href="../logout.php"><?= svg_icon('logout', 20) ?>Déconnexion</a></li>
        </ul>
    </nav>
    <section>
        <div class="dashboard-container">
            <main class="main-content full-width">
                <div class="section-header" style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 16px;">
                    <div>
                        <a href="Lessons.php" style="display: inline-flex; align-items: center; gap: 6px; color: var(--text-mid); text-decoration: none; margin-bottom: 12px; font-weight: 500;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
                            Retour aux leçons
                        </a>
                        <h1><?= htmlspecialchars($lesson['titre']) ?></h1>
                        <p class="subtitle"><?= htmlspecialchars($lesson['code_cours']) ?> • Filière <?= htmlspecialchars($lesson['filiere']) ?></p>
                    </div>
                    <form action="../Teachers/genpdf.php" method="POST" style="margin-top: 24px;">
                        <input type="hidden" name="id_lecon" value="<?= htmlspecialchars($lesson['id_leçon']) ?>">
                        <button type="submit" class="btn-primary" style="padding: 10px 18px; font-size: 15px; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);">
                            <?= svg_icon('emploi', 18) ?> Imprimer (PDF)
                        </button>
                    </form>
                </div>
                
                <div class="card" style="padding: 32px;">
                    <div class="lesson-body" style="white-space: pre-wrap; font-size: 16px; line-height: 1.7; color: var(--text-dark);">
<?= htmlspecialchars($lesson['corps']) ?>
                    </div>
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
