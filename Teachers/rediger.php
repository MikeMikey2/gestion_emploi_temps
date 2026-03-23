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
$id = (int)$_SESSION['id_personne'];
if(isset($_POST['add'])){
$objet=$_POST['objet'];
$message=$_POST['message'];
$time=date('Y-m-d');
$stmt=$con->prepare("INSERT INTO REQUETE(objet,message,date_envoi,id_personne)VALUES(?,?,?,?)");
$stmt->bind_param("sssi",$objet,$message,$time,$id);
if($stmt->execute()){
    echo "<script>alert('Requete envoyée avec succès');</script>";  
}else{
    echo "<script>alert('Erreur lors de l'envoi de la requete');</script>";     
}
$stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>write</title>
    <link rel="stylesheet" href="../style/style2.css">
</head>
<body>
    <div class="Gtitre"><b>GESTION DE L'EMPLOI DU TEMPS</b></div>
      <nav>
     <h5 class="menu">MENU</h5>
         <ul class="nav-list">
            <li><a href="Emploi.php" class="<?= (basename($_SERVER['PHP_SELF'])=='Emploi.php') ? 'nav-active' : '' ?>"><img src="../icons/evenement.jpeg" alt="20" width="30"> Emploi du temps</a></li>
            <li><a href="Requetes.php" class="<?= (basename($_SERVER['PHP_SELF'])=='Requetes.php') ? 'nav-active' : '' ?>"><img src="../icons/request.png" alt="20" width="30">Requetes <span class="badge"><?php echo mysqli_num_rows(mysqli_query($con, "SELECT r.* FROM REQUETE r JOIN PERSONNE p ON r.id_personne = p.id_personne WHERE (r.statut='acceptée' OR r.statut='refusée') AND r.id_personne=$id")); ?></span></a></li>
            <li><a href="Leçons.php" class="<?= (basename($_SERVER['PHP_SELF'])=='Leçons.php') ? 'nav-active' : '' ?>"><img src="../icons/e.png" alt="20" width="30">Leçons</a></li>
        </ul>
        <ul class="nav-footer">
            <li><a href="../logout.php" class="<?= (basename($_SERVER['PHP_SELF'])=='../logout.php') ? 'nav-active' :'' ?>"><img src="../icons/back.png" alt="20" width="30">Deconnexion</a></li>
        </ul>
    </nav>
    <section class="teacher">
        <h1>Rédiger une requête</h1>
        <form action="#" method="POST">
            <input type="text" name="objet" placeholder="Sujet de la requête" required>
            <textarea name="message" placeholder="Entrer votre requête" rows="6" required></textarea>
            <input type="submit" value="Envoyer" name="add" class="btn-primary">
        </form>
    </section>
</body>
</html>