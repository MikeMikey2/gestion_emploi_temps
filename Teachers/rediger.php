<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'enseignant') { 
    header("Location: ../index.php"); 
    exit; 
}
if (!isset($_SESSION['id_personne'])) { 
    header("Location: ../index.php"); 
    exit; 
}

include_once "../ADMIN/con_dbb.php";
include_once "../icons/icons.php";
$id = (int)$_SESSION['id_personne'];

if(isset($_POST['add'])){
    $objet = $_POST['objet'];
    $message = $_POST['message'];
    $time = date('Y-m-d');
    $stmt = $con->prepare("INSERT INTO REQUETE(objet,message,date_envoi,id_personne)VALUES(?,?,?,?)");
    $stmt->bind_param("sssi", $objet, $message, $time, $id);
    try {
        $stmt->execute();
        $msg_requete = ["type" => "success", "text" => "Requête envoyée avec succès."];
    } catch (mysqli_sql_exception $e) {
        $msg_requete = ["type" => "error", "text" => "Erreur BDD : " . $e->getMessage()];     
    }
    $stmt->close();
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
    <title>Rédiger une requête</title>
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
        <h1>Rédiger une requête</h1>
        <?php if(isset($msg_requete)): ?>
            <div class="msg <?= $msg_requete['type'] === 'success' ? 'msg-success' : 'msg-error' ?>">
                <?= $msg_requete['type'] === 'success' ? svg_icon('success', 18) : svg_icon('warning', 18) ?>
                <span><?= htmlspecialchars($msg_requete['text']) ?></span>
            </div>
        <?php endif; ?>
        <form action="#" method="POST">
            <div class="form-group">
                <label for="objet">Objet de la requête</label>
                <input id="objet" type="text" name="objet" class="form-control" placeholder="Ex: Congé maladie, absence exceptionnelle..." required>
            </div>
            <div class="form-group">
                <label for="message">Message</label>
                <textarea id="message" name="message" class="form-control textarea-rich" placeholder="Entrez le corps de votre requête" rows="6" required></textarea>
            </div>
            <div class="form-actions">
                <button type="button" class="btn-cancel" onclick="location.href='Requetes.php'"><?= svg_icon('close', 16) ?> Annuler</button>
                <button type="submit" name="add" class="btn-submit"><?= svg_icon('lesson', 18) ?> Envoyer</button>
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