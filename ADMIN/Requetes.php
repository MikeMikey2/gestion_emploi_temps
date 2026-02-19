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
        <h1>Liste des requetes</h1>
        <div class="choix">
            <p>Voici la liste de toutes les requetes !</p>
    </section>
      <section class="requests-section">
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
                                    <button type="submit" name="action" value="accept" class="btn-accept">Accepter</button> 
                                    <button type="submit" name="action" value="reject" class="btn-reject">Rejeter</button> 
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
                            echo '<p>Aucune requête en attente.</p>';
                        }
                        ?>
        </div>
        
      </section>
</body>
</html>