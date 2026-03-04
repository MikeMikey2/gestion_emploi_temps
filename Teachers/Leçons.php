<?php
session_start(); 
include_once "../ADMIN/con_dbb.php";
$id = (int)$_SESSION['id_personne'];
if(isset($_POST['btn'])) {
    $id_cours = $_POST['id_cours'];
    $title = $_POST['title'];
    $corp = $_POST['corp'];
    var_dump($_POST);
    die();
    $lesson=$con->prepare("INSERT INTO LEÇON (id_cours, titre, corp, id_personne) VALUES (?, ?, ?, ?)");
    $lesson->bind_param("sssi", $id_cours, $title, $corp, $id);
    if($lesson->execute()){
         $_SESSION['lecon_title']     = $title;
         $_SESSION['lecon_corp']      = $corp;
         $_SESSION['lecon_id_cours']  = $id_cours;
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
        <section class="form-container">
        <h1>Créer une nouvelle leçon</h1>
        <form action="" method="post">
                <div class="row">
                        <div class="form-group col-1">
                                <label for="code_cours">Matière / Code du cours</label>
                                <input list="cours_list" id="id_cours" name="id_cours" class="form-control" placeholder="Entrer le code du cours" maxlength="40" aria-describedby="code_help" required>
                                <datalist id="cours_list">
                                        <option value="MATH101">
                                        <option value="PHY101">
                                        <option value="FR101">
                                </datalist>
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

                <div class="form-actions">
                        <button type="button" class="btn-cancel" onclick="location.href='Emploi.php'">Annuler</button>
                        <button type="submit" name="btn" class="btn-submit"> Publier la leçon</button>
                </div>
        </form>
</section>
</body>
</html>