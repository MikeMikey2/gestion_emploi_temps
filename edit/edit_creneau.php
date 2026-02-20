<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
include_once "../ADMIN/con_dbb.php";
$id = isset($_GET['id']) ? $_GET['id'] : (isset($_POST['id']) ? $_POST['id'] : null);

$message = null;
$message_type = null;

if(isset($_POST['date']) &&
 isset($_POST['heure_debut']) && 
 isset($_POST['heure_fin']) &&
  isset($_POST['salle']) &&
  isset($_POST['id_cours']) &&
  isset($_POST['id_admin']) &&
  isset($_POST['code_cours']) &&
  isset($_POST['filiere']) &&
  isset($_POST['id_personne']) &&
  $_POST['date'] != '' &&    
  $_POST['heure_debut'] != '' &&
  $_POST['heure_fin'] != '' &&
  $_POST['salle'] != '' &&
  $_POST['id_cours'] != '' &&
  $_POST['id_admin'] != '' &&
  $_POST['id_personne'] != '' &&
  $_POST['code_cours'] != '' &&
  $_POST['filiere'] != ''){
        $date = $_POST['date'];
        $heure_debut = $_POST['heure_debut'];
        $heure_fin = $_POST['heure_fin'];
        $salle = $_POST['salle'];
        $id_cours = $_POST['id_cours'];
        $id_admin = $_POST['id_admin'];
        $code_cours = $_POST['code_cours'];
        $filiere = $_POST['filiere'];
        $id_personne = $_POST['id_personne'];

    $stmt = $con->prepare("UPDATE CRENEAU SET date=?, heure_debut=?, heure_fin=?, salle=?, id_cours=?, id_admin=?, code_cours=?, filiere=?, id_personne=? WHERE id_creneau=?");
$stmt->bind_param("ssssiiiisii", $date, $heure_debut, $heure_fin, $salle, $id_cours, $id_admin, $code_cours, $filiere, $id_personne, $id);

    if($stmt->execute()){
        $message = "Créneau modifié avec succès";
        $message_type = "success";
    }else{
        $message = "Erreur lors de la modification";
        $message_type = "error";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter</title>
    <link rel="stylesheet" href="../style/style2.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="Gtitre"><b>GESTION DE L'EMPLOI DU TEMPS</b></div>
    <nav>
       <h5 class="menu">MENU</h5>
        <ul class="nav-list">
            <li><a href="../ADMIN/tableau.php" class="<?= (basename($_SERVER['PHP_SELF'])=='tableau.php') ? 'nav-active' : '' ?>"><img src="../icons/table.png" alt="20" width="30">Tableau de bord</a></li>
            <li><a href="../ADMIN/Gestion.php" class="<?= (basename($_SERVER['PHP_SELF'])=='Gestion.php') ? 'nav-active' : '' ?>"><img src="../icons/per.png" alt="20" width="30">Gestion</a></li>
            <li><a href="../ADMIN/Emploi.php" class="<?= (basename($_SERVER['PHP_SELF'])=='Emploi.php') ? 'nav-active' : '' ?>"><img src="../icons/evenement.png" alt="20" width="30"> Emploi du temps</a></li>
            <li><a href="../ADMIN/Requetes.php" class="<?= (basename($_SERVER['PHP_SELF'])=='Requetes.php') ? 'nav-active' : '' ?>"><img src="../icons/message.jpeg" alt="20" width="30">Requetes<span class="badge"><?php echo mysqli_num_rows(mysqli_query($con, "SELECT * FROM REQUETE WHERE statut='en_attente'")); ?></span></a></li>
        </ul>
    </nav>
    <section>
        <div class="teacher">
            <h1>Modifier le Créneau</h1>
            <?php if($message): ?>
                <div class="form-message form-message-<?= $message_type ?>">
                    <i class="fas fa-<?= $message_type === 'success' ? 'check-circle' : 'exclamation-circle' ?>"></i>
                    <span><?= htmlspecialchars($message) ?></span>
                </div>
            <?php endif; ?>

            <?php
           
            $stmt2 = $con->prepare("SELECT * FROM CRENEAU WHERE id_creneau = ?");
            $stmt2->bind_param("i", $id);
            $stmt2->execute();
            $result = $stmt2->get_result();
        
            while($creneau = mysqli_fetch_assoc($result)){
            ?>
                <form action="#" method="POST" novalidate>
                <input type="hidden" name="id" value="<?=($creneau['id_creneau']) ?>">

                <input type="text" name="date" placeholder="Date" value="<?= htmlspecialchars($creneau['date']) ?>" required>
                <input type="text" name="heure_debut" placeholder="Heure de début" value="<?= htmlspecialchars($creneau['heure_debut']) ?>" required>
                <input type="text" name="heure_fin" placeholder="Heure de fin" value="<?= htmlspecialchars($creneau['heure_fin']) ?>" required>
                <input type="text" name="salle" placeholder="Salle" value="<?= htmlspecialchars($creneau['salle']) ?>" required>
                <input type="text" name="id_cours" placeholder="ID cours" value="<?= htmlspecialchars($creneau['id_cours']) ?>" required>
                <input type="text" name="id_admin" placeholder="ID admin" value="<?= htmlspecialchars($creneau['id_admin']) ?>" required>
                <input type="text" name="code_cours" placeholder="Code cours" value="<?= htmlspecialchars($creneau['code_cours']) ?>" required>
                <input type="text" name="filiere" placeholder="Filière" value="<?= htmlspecialchars($creneau['filiere']) ?>" required>
                <input type="text" name="id_personne" placeholder="ID personne" value="<?= htmlspecialchars($creneau['id_personne']) ?>" required>
                
                <input type="submit" value="Modifier" name="add">
            </form>
            <?php } ?>
        </div>
    </section>
</body>
</html>