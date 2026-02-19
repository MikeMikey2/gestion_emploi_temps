<?php
include_once "con_dbb.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Requetes</title>
    <link rel="stylesheet" href="../style/style2.css">
</head>
<body>
       <div class="Gtitre"><b>GESTION DES REQUETES</b></div>
      <nav>
              <h5 class="menu">MENU</h5>
         <ul class="nav-list">
            <li><a href="tableau.php" class="<?= (basename($_SERVER['PHP_SELF'])=='tableau.php') ? 'nav-active' : '' ?>"><img src="../icons/table.png" alt="20" width="30">Tableau de bord</a></li>
            <li><a href="Gestion.php" class="<?= (basename($_SERVER['PHP_SELF'])=='Gestion.php') ? 'nav-active' : '' ?>"><img src="../icons/per.png" alt="20" width="30">Gestion</a></li>
            <li><a href="Emploi.php" class="<?= (basename($_SERVER['PHP_SELF'])=='Emploi.php') ? 'nav-active' : '' ?>"><img src="../icons/evenement.png" alt="20" width="30"> Emploi du temps</a></li>
            <li><a href="Requetes.php" class="<?= (basename($_SERVER['PHP_SELF'])=='Requetes.php') ? 'nav-active' : '' ?>"><img src="../icons/message.jpeg" alt="20" width="30">Requetes <span class="badge"><?php echo mysqli_num_rows(mysqli_query($con, "SELECT * FROM REQUETE WHERE statut='en_attente'")); ?></span></a></li>
        </ul>
    </nav>
    <section>
        <div class="manage-tabs">
            <button class="tab-btn active" data-tab="waiting-tab">En attente</button>
            <button class="tab-btn" data-tab="history-tab">Refusées & Acceptées</button>
        </div>
        <h1>Liste des requetes</h1>
        <div class="choix">
            <p>Voici la liste de toutes les requetes !</p>
    </section>
      <section class="requests-section">
        <div class="tab-content" id="waiting-tab">
        <div class="requests-grid">
                        <?php
                        // Helper to render a single request card
                        function render_request_card($r){
                            ?>
                            <div class="request-card pending">
                                <div class="request-header">
                                    <div class="request-info">
                                        <span class="request-status status-pending">En attente</span>
                                        <span class="request-date"><?=htmlspecialchars($r['date_envoi'] ?? '')?></span>
                                    </div>
                                </div>
                                <h3 class="request-title"><?=htmlspecialchars($r['objet'] ?? '')?></h3>
                                <p class="request-message"><?=nl2br(htmlspecialchars($r['message'] ?? ''))?></p>
                              <div class="request-actions"> 
                                <form method="POST" action="handle_request.php" style="display:inline;"> 
                                    <input type="hidden" name="request_id" value="<?=htmlspecialchars($r['id_requete'])?>"> 
                                    <button type="submit" name="action1" value="accept" class="btn-accept">Accepter</button> 
                                    <button type="submit" name="action2" value="reject" class="btn-reject">Rejeter</button> 
                                </form>
                             </div> 
                            </div>
                             <?php } ?>
                            </div>
                            <?php
                        

                        // Récupérer et afficher toutes les requêtes en attente (sans regroupement par conteneur)
                        $str = mysqli_query($con, "SELECT * FROM REQUETE WHERE statut='en_attente' ORDER BY date_envoi DESC");
                        if($str && mysqli_num_rows($str) > 0){
                            while($r = mysqli_fetch_assoc($str)){
                                render_request_card($r);
                            }
                        } else {
                            echo '<p>Aucune requête acceptée.</p>';
                        }
                        ?>
        </div>
        </div>
        <div class="tab-content" id="history-tab">
        <div class="requests-grid">
                        <?php
                        // Helper to render a single request card
                        function render_accept_card($re){
                            ?>
                            <div class="request-card accepted">
                                <div class="request-header">
                                    <div class="request-info">
                                        <span class="request-status status-accepted">Acceptée</span>
                                        <span class="request-date"><?=htmlspecialchars($re['date_envoi'] ?? '')?></span>
                                    </div>
                                </div>
                                <h3 class="request-title"><?=htmlspecialchars($re['objet'] ?? '')?></h3>
                                <p class="request-message"><?=nl2br(htmlspecialchars($re['message'] ?? ''))?></p>
                              <div class="request-actions"> 
                                <form method="POST" action="handle_request.php" style="display:inline;"> 
                                    <input type="hidden" name="request_id" value="<?=htmlspecialchars($re['id_requete'] ?? '')?>"> 
                                    <button type="submit" name="action3" value="update" class="btn-update">Modifier</button>
                                </form>
                             </div> 
                            </div>
                             <?php } ?>
                            </div>
                            <?php
                        

                        // Récupérer et afficher toutes les requêtes accept (sans regroupement par conteneur)
                        $str2 = mysqli_query($con, "SELECT * FROM REQUETE WHERE statut='acceptée' ORDER BY date_envoi DESC");
                        if($str2 && mysqli_num_rows($str2) > 0){
                            while($re = mysqli_fetch_assoc($str2)){
                                render_accept_card($re);
                            }
                        } else {
                            echo '<p>Aucune requête acceptée.</p>';
                        }
                        ?>
        
        <div class="requests-grid">
                        <?php
                        // Helper to render a single request card
                        function render_pending_card($res){
                            ?>
                            <div class="request-card rejected">
                                <div class="request-header">
                                    <div class="request-info">
                                        <span class="request-status status-rejected">Refusée</span>
                                        <span class="request-date"><?=htmlspecialchars($res['date_envoi'] ?? '')?></span>
                                    </div>
                                </div>
                                <h3 class="request-title"><?=htmlspecialchars($res['objet'] ?? '')?></h3>
                                <p class="request-message"><?=nl2br(htmlspecialchars($res['message'] ?? ''))?></p>
                              <div class="request-actions"> 
                                <form method="POST" action="handle_request.php" style="display:inline;"> 
                                    <input type="hidden" name="request_id" value="<?=htmlspecialchars($res['id_requete'] ?? '')?>"> 
                                    <button type="submit" name="action3" value="update" class="btn-update">Modifier</button>
                                </form>
                             </div> 
                            </div>
                             <?php } ?>
                            </div>
                            <?php
                        

                        // Récupérer et afficher toutes les requêtes refusées
                        $str3 = mysqli_query($con, "SELECT * FROM REQUETE WHERE statut='refusée' ORDER BY date_envoi DESC");
                        if($str3 && mysqli_num_rows($str3) > 0){
                            while($res = mysqli_fetch_assoc($str3)){
                                render_pending_card($res);
                            }
                        } else {
                            echo '<p>Aucune requête refusée.</p>';
                        }
                        ?>
        </div>
        </div>
        </div>
      </section>
      <script>
        // Gestion des onglets pour afficher les données filtrées
        document.addEventListener('DOMContentLoaded', function() {
            // Masquer tous les onglets sauf le premier au chargement
            const allTabContents = document.querySelectorAll('.tab-content');
            allTabContents.forEach((content, index) => {
                if (index === 0) {
                    content.classList.add('active');
                    content.style.display = 'block';
                } else {
                    content.classList.remove('active');
                    content.style.display = 'none';
                }
            });
            
            // Récupérer tous les boutons d'onglet
            const tabButtons = document.querySelectorAll('.tab-btn');
            
            // Ajouter un événement click à chaque bouton
            tabButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Récupérer l'attribut data-tab du bouton cliqué
                    const tabName = this.getAttribute('data-tab');
                    
                    // Afficher uniquement le contenu sélectionné
                    showTab(tabName);
                    
                    // Mettre à jour le style du bouton actif
                    tabButtons.forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');
                });
            });
        });

        // Fonction pour afficher l'onglet sélectionné
        function showTab(tabName) {
            // Masquer tous les onglets
            const allTabContents = document.querySelectorAll('.tab-content');
            allTabContents.forEach(content => {
                content.classList.remove('active');
                content.style.display = 'none';
            });
            
            // Afficher l'onglet sélectionné
            const selectedTab = document.getElementById(tabName);
            if (selectedTab) {
                selectedTab.classList.add('active');
                selectedTab.style.display = 'block';
            }
        }
      </script>
</body>
</html>