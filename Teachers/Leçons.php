<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'enseignant') {
    header("Location: ../index.php");
    exit;
}
include_once "../ADMIN/con_dbb.php";
include_once "../icons/icons.php";
   $id = (int)$_SESSION['id_personne'];
if(isset($_POST['btn'])) {
    $id_cours = $_POST['id_cours'];
    $title = $_POST['title'];
    $corp = $_POST['corp'];
    $filiere = $_POST['filiere'];
    $lesson= mysqli_prepare($con,"INSERT INTO LEÇON (id_cours, titre, corps, id_personne, filiere) VALUES (?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($lesson, "issis", $id_cours, $title, $corp, $id, $filiere);
    if(mysqli_stmt_execute($lesson)){
       $msg_lecon = ["type" => "success", "text" => "Leçon publiée avec succès !"];
    }else{
        $msg_lecon = ["type" => "error", "text" => "Erreur lors de la publication."];
    }
}
$stmt_badge = $con->prepare("SELECT COUNT(*) as total FROM REQUETE WHERE (statut='acceptee' OR statut='refusee') AND id_personne = ?");
$stmt_badge->bind_param("i", $id);
$stmt_badge->execute();
$badge = $stmt_badge->get_result()->fetch_assoc()['total'];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer une leçon</title>
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
            <li><a href="Requetes.php" class="<?= (basename($_SERVER['PHP_SELF'])=='Requetes.php') ? 'nav-active' : '' ?>"><?= svg_icon('requetes', 20) ?>Requêtes <span class="badge"><?php echo $badge; ?></span></a></li>
            <li><a href="Leçons.php" class="<?= (basename($_SERVER['PHP_SELF'])=='Leçons.php') ? 'nav-active' : '' ?>"><?= svg_icon('lesson', 20) ?>Leçons</a></li>
        </ul>
        <ul class="nav-footer" id="navFooter">
            <li><a href="../logout.php"><?= svg_icon('logout', 20) ?>Déconnexion</a></li>
        </ul>
    </nav>
        <section class="form-container">
        <h1>Créer une nouvelle leçon</h1>
        <?php if(isset($msg_lecon)): ?>
            <div class="msg <?= $msg_lecon['type'] === 'success' ? 'msg-success' : 'msg-error' ?>">
                <?= $msg_lecon['type'] === 'success' ? svg_icon('success', 18) : svg_icon('warning', 18) ?>
                <span><?= htmlspecialchars($msg_lecon['text']) ?></span>
            </div>
        <?php endif; ?>
        <form action="" method="post">
                <div class="row">
                        <div class="form-group col-1">
                                <label for="code_cours">Matière / Code du cours</label>
                                <select id="cours_list" name="id_cours" class="form-control">
                                        <option value="1">MATH301</option>
                                        <option value="2">PHY402</option>
                                        <option value="3">INFO201</option>
                                        <option value="4">INFO305</option>
                                        <option value="5">INFO401</option>
                                </select>
                                <small id="code_help" class="form-help">Sélectionnez ou tapez un code/matière.</small>
                        </div>
                        <div class="form-group col-2">
                                <label for="title">Titre de la leçon</label>
                                <input id="title" type="text" name="title" class="form-control" placeholder="Entrer le titre de la leçon" maxlength="120" aria-describedby="title_count" required>
                        </div>
                </div>

                <div class="form-group">
                        <label for="corp">Contenu de la leçon</label>
                        <textarea name="corp" id="corp" class="form-control textarea-rich" placeholder="Rédigez votre leçon..." required></textarea>
                </div>
                <div class="form-group">
                        <select id="filiere"  name="filiere" class="form-control">
                                <option value="IGL1">IGL1</option>
                                <option value="IGL2">IGL2</option>
                                <option value="BAT1">BAT1</option>
                                <option value="BAT2">BAT2</option>
                                <option value="ELT1">ELT1</option>
                                <option value="ELT2">ELT2</option>
                                <option value="FCL1">FCL1</option>
                                <option value="FCL2">FCL2</option>
                                <option value="GTO1">GTO1</option>
                                <option value="GTO2">GTO2</option>
                                <option value="IIA1">IIA1</option>
                                <option value="IIA2">IIA2</option>
                                <option value="IWD1">IWD1</option>
                                <option value="IWD2">IWD2</option>
                                <option value="MAB1">MAB1</option>
                                <option value="MAB2">MAB2</option>
                                <option value="MAVA1">MAVA1</option>
                                <option value="MAVA2">MAVA2</option>
                                <option value="RES1">RES1</option>
                                <option value="RES2">RES2</option>
                                <option value="2ndeC">2ndeC</option>
                                <option value="1ereC">1ereC</option>
                                <option value="TC">TC</option>
                                <option value="TEL1">TEL1</option>
                                <option value="TEL2">TEL2</option>
                        </select>
                        <small id="filiere_help" class="form-help">Indiquez la filière si la leçon est spécifique à une.</small>
                </div>
                <div class="form-actions">
                        <button type="button" class="btn-cancel" onclick="location.href='Emploi.php'"><?= svg_icon('close', 16) ?> Annuler</button>
                        <button type="submit" name="btn" class="btn-submit"><?= svg_icon('lesson', 18) ?> Publier la leçon</button>
                </div>
        </form>
</section>

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