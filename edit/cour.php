<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
include_once "../ADMIN/con_dbb.php";
$id = isset($_GET['id']) ? $_GET['id'] : (isset($_POST['id']) ? $_POST['id'] : null);

$message = null;
$message_type = null;

if(isset($_POST['code_cours']) &&
 isset($_POST['nom_cours']) && 
 isset($_POST['description']) &&
  $_POST['code_cours'] != '' &&    
  $_POST['nom_cours'] != '' &&
  $_POST['description'] != ''){
        $code_cours = $_POST['code_cours'];
        $nom_cours = $_POST['nom_cours'];
        $description  = $_POST['description'];
    $stmt = $con->prepare("UPDATE COURS SET code_cours=?, nom_cours=?, description=? WHERE id_cours=?");
    $stmt->bind_param("sssi", $code_cours, $nom_cours, $description, $id);

    if($stmt->execute()){
        $message = "Cours modifié avec succès";
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
    <title>Modifier</title>
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
            <h1>Modifier le Cours</h1>
            <?php if($message): ?>
                <div class="form-message form-message-<?= $message_type ?>">
                    <i class="fas fa-<?= $message_type === 'success' ? 'check-circle' : 'exclamation-circle' ?>"></i>
                    <span><?= htmlspecialchars($message) ?></span>
                </div>
            <?php endif; ?>

            <?php
           
            $stmt2 = $con->prepare("SELECT * FROM COURS WHERE id_cours = ?");
            $stmt2->bind_param("i", $id);
            $stmt2->execute();
            $result = $stmt2->get_result();
        
            while($cours = mysqli_fetch_assoc($result)){
            ?>
                <form action="#" method="POST" novalidate>
                <input type="hidden" name="id" value="<?=($cours['id_cours']) ?>">

                <input 
                    type="text" 
                    name="code_cours" 
                    placeholder="Code du cours"
                    value="<?= htmlspecialchars($cours['code_cours']) ?>" 
                    required>
                
                <input 
                    type="text" 
                    name="nom_cours" 
                    placeholder="Nom du cours"
                    value="<?= htmlspecialchars($cours['nom_cours']) ?>" 
                    required>
                
                <input 
                    type="text" 
                    name="description" 
                    placeholder="Description"
                    value="<?= htmlspecialchars($cours['description']) ?>" 
                    required>
                
                
                <input 
                    type="submit" 
                    value="Modifier" 
                    name="add">
            </form>
            <?php } ?>
        </div>
    </section>

    
</body>
</html>