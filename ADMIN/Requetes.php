<?php
include_once "con_dbb.php";
include_once "../icons/icons.php";
//si on valide une requete
if(isset($_POST['action1'])) {
    $request_id =isset($_GET['request_id']) ? $_GET['request_id'] : (isset($_POST['request_id']) ? $_POST['request_id'] : null);
    $update_sql = "UPDATE REQUETE SET statut='acceptee' WHERE id_requete=?";
    $stmt = $con->prepare($update_sql);
    $stmt->bind_param("i", $request_id);
    $stmt->execute();
    header("Location: Requetes.php");
    exit();
}elseif(isset($_POST['action2'])) {
    $request_id =isset($_GET['request_id']) ? $_GET['request_id'] : (isset($_POST['request_id']) ? $_POST['request_id'] : null);
    $update_sql = "UPDATE REQUETE SET statut='refusee' WHERE id_requete=?";
    $stmt = $con->prepare($update_sql);
    $stmt->bind_param("i", $request_id);
    $stmt->execute();
    header("Location: Requetes.php");
    exit();
}elseif(isset($_POST['action3'])) {
    $request_id =isset($_GET['request_id']) ? $_GET['request_id'] : (isset($_POST['request_id']) ? $_POST['request_id'] : null);
    $update_sql = "UPDATE REQUETE SET statut='en_attente' WHERE id_requete=?";
    $stmt = $con->prepare($update_sql);
    $stmt->bind_param("i", $request_id);
    $stmt->execute();
    header("Location: Requetes.php");
    exit();
}elseif(isset($_POST['action4'])) {
    $request_id =isset($_GET['request_id']) ? $_GET['request_id'] : (isset($_POST['request_id']) ? $_POST['request_id'] : null);
    $delete_sql = "DELETE FROM REQUETE WHERE id_requete=?";
    $stmt = $con->prepare($delete_sql);
    $stmt->bind_param("i", $request_id);
    $stmt->execute();
    header("Location: Requetes.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Requêtes</title>
    <link rel="stylesheet" href="../style/style2.css">
</head>
<body>
    <div class="Gtitre"><b>GESTION DES REQUÊTES</b></div>
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
    <section>
        <div class="manage-tabs">
            <button class="tab-btn active" data-tab="waiting-tab">En attente</button>
            <button class="tab-btn" data-tab="history-tab">Refusées &amp; Acceptées</button>
        </div>
        <h1>Liste des requêtes</h1>
        <div class="choix">
            <p>Voici la liste de toutes les requêtes !</p>
    </section>
    <section class="requests-section">
        <div class="tab-content" id="waiting-tab">
        <div class="requests-grid">
                        <?php
                        
                        function render_request_card($r){
                            global $svg_icon_fn; // use global function
                            ?>
                            <div class="request-card pending">
                                <div class="request-header">
                                    <div class="request-info">
                                        <span class="request-status status-pending">En attente</span>
                                        <span class="request-name"><?=htmlspecialchars($r['nom'] ?? '')?> <?=htmlspecialchars($r['prenom'] ?? '')?></span>
                                        <span class="request-date"><?=htmlspecialchars($r['date_envoi'] ?? '')?></span>
                                    </div>
                                </div>
                                <h3 class="request-title"><?=htmlspecialchars($r['objet'] ?? '')?></h3>
                                <p class="request-message"><?=nl2br(htmlspecialchars($r['message'] ?? ''))?></p>
                              <div class="request-actions"> 
                                <form method="POST" action="#" style="display:inline;"> 
                                    <input type="hidden" name="request_id" value="<?=htmlspecialchars($r['id_requete'])?>"> 
                                    <button type="submit" name="action1" value="accept" class="btn-accept"><?= svg_icon('check', 16) ?> Accepter</button> 
                                    <button type="submit" name="action2" value="reject" class="btn-reject"><?= svg_icon('close', 16) ?> Rejeter</button> 
                                </form>
                             </div> 
                            </div>
                             <?php } ?>
                            </div>
                            <?php

                        // Récupérer et afficher toutes les requêtes en attente
                        $str = mysqli_query($con, "SELECT r.*, p.nom, p.prenom FROM REQUETE r JOIN PERSONNE p ON r.id_personne = p.id_personne WHERE r.statut='en_attente' ORDER BY r.date_envoi DESC");
                        if($str && mysqli_num_rows($str) > 0){
                            while($r = mysqli_fetch_assoc($str)){
                                render_request_card($r);
                            }
                        } else {
                            echo '<p class="request-empty">Aucune requête en attente.</p>';
                        }
                        ?>
        </div>
        </div>
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
                                <form method="POST" action="#" style="display:inline;"> 
                                    <input type="hidden" name="request_id" value="<?=htmlspecialchars($re['id_requete'] ?? '')?>"> 
                                    <button type="submit" name="action3" value="update" class="btn-update"><?= svg_icon('emploi', 16) ?> Remettre en attente</button>
                                    <button type="submit" name="action4" value="delete" class="btn-reject"><?= svg_icon('delete', 16) ?> Supprimer</button>
                                </form>
                             </div> 
                            </div>
                             <?php } ?>
                            </div>
                            <?php

                        // Récupérer et afficher toutes les requêtes acceptées (statut sans accent)
                        $str2 = mysqli_query($con, "SELECT r.*, p.nom, p.prenom FROM REQUETE r JOIN PERSONNE p ON r.id_personne = p.id_personne WHERE r.statut='acceptee' ORDER BY r.date_envoi DESC");
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
                                <form method="POST" action="#" style="display:inline;"> 
                                    <input type="hidden" name="request_id" value="<?=htmlspecialchars($res['id_requete'] ?? '')?>"> 
                                    <button type="submit" name="action3" value="update" class="btn-update"><?= svg_icon('emploi', 16) ?> Remettre en attente</button>
                                    <button type="submit" name="action4" value="delete" class="btn-reject"><?= svg_icon('delete', 16) ?> Supprimer</button>
                                </form>
                             </div> 
                            </div>
                             <?php } ?>
                            </div>
                            <?php

                        // Récupérer et afficher toutes les requêtes refusées (statut sans accent)
                        $str3 = mysqli_query($con, "SELECT r.*, p.nom, p.prenom FROM REQUETE r JOIN PERSONNE p ON r.id_personne = p.id_personne WHERE r.statut='refusee' ORDER BY r.date_envoi DESC");
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
        </div>
    </section>
    <script>
        // Gestion des onglets
        document.addEventListener('DOMContentLoaded', function() {
            const allTabContents = document.querySelectorAll('.tab-content');
            allTabContents.forEach((content, logout) => {
                if (logout === 0) {
                    content.classList.add('active');
                    content.style.display = 'block';
                } else {
                    content.classList.remove('active');
                    content.style.display = 'none';
                }
            });
            
            const tabButtons = document.querySelectorAll('.tab-btn');
            tabButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const tabName = this.getAttribute('data-tab');
                    showTab(tabName);
                    tabButtons.forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');
                });
            });
        });

        function showTab(tabName) {
            const allTabContents = document.querySelectorAll('.tab-content');
            allTabContents.forEach(content => {
                content.classList.remove('active');
                content.style.display = 'none';
            });
            const selectedTab = document.getElementById(tabName);
            if (selectedTab) {
                selectedTab.classList.add('active');
                selectedTab.style.display = 'block';
            }
        }

        // Bouton toggle nav
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