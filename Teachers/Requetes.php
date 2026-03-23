<?php
session_start();
include_once "../ADMIN/con_dbb.php";
$id=$_SESSION['id_personne'];
// Badge — requête préparée
$stmt_badge = $con->prepare("SELECT COUNT(*) as total FROM REQUETE WHERE (statut='acceptée' OR statut='refusée') AND id_personne = ?");
$stmt_badge->bind_param("i", $id);
$stmt_badge->execute();
$badge = $stmt_badge->get_result()->fetch_assoc()['total'];
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
            <li><a href="Emploi.php" class="<?= (basename($_SERVER['PHP_SELF'])=='Emploi.php') ? 'nav-active' : '' ?>"><img src="../icons/evenement.jpeg" alt="20" width="30"> Emploi du temps</a></li>
            <li><a href="Requetes.php" class="<?= (basename($_SERVER['PHP_SELF'])=='Requetes.php') ? 'nav-active' : '' ?>"><img src="../icons/request.png" alt="20" width="30">Requetes <span class="badge"><?php echo $badge; ?></span></a></li>
            <li><a href="Leçons.php" class="<?= (basename($_SERVER['PHP_SELF'])=='Leçons.php') ? 'nav-active' : '' ?>"><img src="../icons/e.png" alt="20" width="30">Leçons</a></li>
        </ul>
        <ul class="nav-footer">
            <li><a href="../logout.php" class="<?= (basename($_SERVER['PHP_SELF'])=='../logout.php') ? 'nav-active' :'' ?>"><img src="../icons/back.png" alt="20" width="30">Deconnexion</a></li>
        </ul>
    </nav>
   <section>
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
                        

                        // Récupérer et afficher toutes les requêtes accept (sans regroupement par conteneur)
                        $str2 = mysqli_query($con, "   SELECT r.*, p.nom, p.prenom FROM REQUETE r JOIN PERSONNE p ON r.id_personne = p.id_personne WHERE r.statut='acceptée' AND r.id_personne=$id ORDER BY r.date_envoi DESC");
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
                        

                        // Récupérer et afficher toutes les requêtes refusées
                        $str3 = mysqli_query($con, "SELECT r.*, p.nom, p.prenom FROM REQUETE r JOIN PERSONNE p ON r.id_personne = p.id_personne WHERE r.statut='refusée' AND r.id_personne=$id ORDER BY r.date_envoi DESC");
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
   </section>
</body>
</html>