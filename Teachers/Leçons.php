<?php
session_start(); // ← manquant !
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'enseignant') { 
    header("Location: ../index.php"); 
    exit; 
}
include_once "../ADMIN/con_dbb.php";
$id = (int)$_SESSION['id_personne'];
if(isset($_POST['btn'])) {
    $code_cours = $_POST['code_cours'];
    $nom_leçon = $_POST['nom_leçon'];
    $corp = $_POST['corp'];
    $lesson=mysqli_query($con, "INSERT INTO LEÇON (code_cours, nom_leçon, corp, id_personne) VALUES ('$code_cours', '$nom_leçon', '$corp', $id)");
    $req=$lesson->fetch_all(MYSQLI_ASSOC);
    if($req){
       header("Location: pdf-content.php");
       exit();
    }else{
        echo "Erreur";
    }
    
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cours</title>
    <link rel="stylesheet" href="../style/style2.css">
</head>
<body>
    <div class="Gtitre"><b>GESTION DE L'EMPLOI DU TEMPS</b></div>
      <nav>
     <h5 class="menu">MENU</h5>
         <ul class="nav-list">
            <li><a href="Emploi.php" class="<?= (basename($_SERVER['PHP_SELF'])=='Emploi.php') ? 'nav-active' : '' ?>"><img src="../icons/evenement.png" alt="20" width="30"> Emploi du temps</a></li>
            <li><a href="Requetes.php" class="<?= (basename($_SERVER['PHP_SELF'])=='Requetes.php') ? 'nav-active' : '' ?>"><img src="../icons/message.jpeg" alt="20" width="30">Requetes <span class="badge"><?php echo mysqli_num_rows(mysqli_query($con, "SELECT r.* FROM REQUETE r JOIN PERSONNE p ON r.id_personne = p.id_personne WHERE (r.statut='acceptée' OR r.statut='refusée') AND r.id_personne=$id")); ?></span></a></li>
            <li><a href="Leçons.php" class="<?= (basename($_SERVER['PHP_SELF'])=='Leçons.php') ? 'nav-active' : '' ?>"><img src="../icons/prof.png" alt="20" width="30">Leçons</a></li>
            <li><a href="../logout.php" class="<?= (basename($_SERVER['PHP_SELF'])=='../logout.php') ? 'nav-active' :'' ?>"><img src="../icons/back.jpeg" alt="20" width="30">Deconnexion</a></li>
        </ul>
    </nav>
    <section>
        <h1>Mes leçons</h1>
        <p>Contenu des leçons à venir...</p>
        <form action="#" method="post">
            <h1><input type="text" name="code_cours" placeholder="Nom de la matière"></h1>
            <h2><input type="text" name="nom_leçon" placeholder="Nom de la leçon"></h2>
            <textarea name="corp" id="" placeholder="Contenu de la leçon"></textarea>
            <button class="btn-primary" name="btn">Envoyer</button>
        </form>
    </section>
</body>
</html>