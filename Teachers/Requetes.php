<?php
session_start();
include_once "../ADMIN/con_dbb.php";
include_once "../icons/icons.php";
$id=$_SESSION['id_personne'];
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
    <title>Mes requêtes</title>
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
   <section>
    <div class="tab-content" id="history-tab">
        <div class="requests-grid">
                        <?php
                        function render_accept_card($re){
                            ?>
                            <div class="request-card accepted">
                                <div class="request-header">
                                    <div class="request-info">
                                        <span class="request-status status-accepted">Acceptée</span>
                                        <span class="request-name"><?=htmlspecialchars($re['nom'] ?? '')?> <?=htmlspecialchars($re['prenom'] ?? '')?></span>
                                        <span class="request-date"><?=htmlspecialchars($re['date_envoi'] ?? '')?></span>
                                    </div>
                                </div>
                                <h3 class="request-title"><?=htmlspecialchars($re['objet'] ?? '')?></h3>
                                <p class="request-message"><?=nl2br(htmlspecialchars($re['message'] ?? ''))?></p>
                              <div class="request-actions"> 
              
                             </div> 
                            </div>
                             <?php } ?>
                            </div>
                            <?php

                        $str2 = mysqli_query($con, "SELECT r.*, p.nom, p.prenom FROM REQUETE r JOIN PERSONNE p ON r.id_personne = p.id_personne WHERE r.statut='acceptee' AND r.id_personne=$id ORDER BY r.date_envoi DESC");
                        if($str2 && mysqli_num_rows($str2) > 0){
                            while($re = mysqli_fetch_assoc($str2)){
                                render_accept_card($re);
                            }
                        } else {
                            echo '<p class="request-empty">Aucune requête acceptée.</p>';
                        }
                        ?>
    
        <div class="requests-grid">
                        <?php
                        function render_pending_card($res){
                            ?>
                            <div class="request-card rejected">
                                <div class="request-header">
                                    <div class="request-info">
                                        <span class="request-status status-rejected">Refusée</span>
                                        <span class="request-name"><?=htmlspecialchars($res['nom'] ?? '')?> <?=htmlspecialchars($res['prenom'] ?? '')?></span>
                                        <span class="request-date"><?=htmlspecialchars($res['date_envoi'] ?? '')?></span>
                                    </div>
                                </div>
                                <h3 class="request-title"><?=htmlspecialchars($res['objet'] ?? '')?></h3>
                                <p class="request-message"><?=nl2br(htmlspecialchars($res['message'] ?? ''))?></p>
                              <div class="request-actions"> 
                             </div> 
                            </div>
                             <?php } ?>
                            </div>
                            <?php

                        $str3 = mysqli_query($con, "SELECT r.*, p.nom, p.prenom FROM REQUETE r JOIN PERSONNE p ON r.id_personne = p.id_personne WHERE r.statut='refusee' AND r.id_personne=$id ORDER BY r.date_envoi DESC");
                        if($str3 && mysqli_num_rows($str3) > 0){
                            while($res = mysqli_fetch_assoc($str3)){
                                render_pending_card($res);
                            }
                        } else {
                            echo '<p class="request-empty">Aucune requête refusée.</p>';
                        }
                        ?>
        </div>
        </div>
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