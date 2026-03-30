<?php
try {
    $conn = new PDO("mysql:host=localhost;dbname=emploi", "phpmyadmin", "mbele2.0");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Erreur de connexion: " . $e->getMessage());
}

$message = null;
$message_type = null;

if(isset($_POST['add'])) {
    $code_cours = $_POST['code_cours'] ?? '';
    $nom_cours = $_POST['nom_cours'] ?? '';
    $description = $_POST['description'] ?? '';
    
    // Vérifier que les champs ne sont pas vides
    if(empty($code_cours) || empty($nom_cours) || empty($description)) {
        $message = "Tous les champs sont obligatoires";
        $message_type = "error";
    } else {
        try {
            $stmt = $conn->prepare("INSERT INTO COURS(code_cours, nom_cours, description) VALUES(?, ?, ?)");
            
            if($stmt->execute([$code_cours, $nom_cours, $description])) {
                $message = "Cours ajouté avec succès";
                $message_type = "success";
                $code_cours = $nom_cours = $description = '';
            } else {
                $message = "Erreur lors de l'ajout du cours";
                $message_type = "error";
            }
        } catch(PDOException $e) {
            $message = "Erreur: " . $e->getMessage();
            $message_type = "error";
        }
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
            <li><a href="../ADMIN/Gestion.php" class="<?= (basename($_SERVER['PHP_SELF'])=='Gestion.php') ? 'nav-active' : '' ?>"><img src="../icons/prof.png" alt="20" width="30">Gestion</a></li>
            <li><a href="../ADMIN/Emploi.php" class="<?= (basename($_SERVER['PHP_SELF'])=='Emploi.php') ? 'nav-active' : '' ?>"><img src="../icons/evenement.png" alt="20" width="30"> Emploi du temps</a></li>
            <li><a href="../ADMIN/Requetes.php" class="<?= (basename($_SERVER['PHP_SELF'])=='Requetes.php') ? 'nav-active' : '' ?>"><img src="../icons/message.jpeg" alt="20" width="30">Requetes<span class="badge"><?php $pending = $conn->query("SELECT COUNT(*) FROM REQUETE WHERE statut='en_attente'")->fetchColumn(); echo $pending; ?></span></a></li>
            <li><a href="../logout.php" class="<?= (basename($_SERVER['PHP_SELF'])=='../logout.php') ? 'nav-active' :'' ?>"><img src="../icons/back.jpeg" alt="20" width="30">Deconnexion</a></li>
        </ul>
    </nav>
    <section>
        <div class="teacher">
            <h1>Ajouter un Cours</h1>
            <?php if($message): ?>
                <div class="form-message form-message-<?= $message_type ?>">
                    <i class="fas fa-<?= $message_type === 'success' ? 'check-circle' : ($message_type === 'error' ? 'exclamation-circle' : 'info-circle') ?>"></i>
                    <span><?= htmlspecialchars($message) ?></span>
                </div>
            <?php endif; ?>
            <form action="" method="POST" novalidate>
                <input 
                    type="text" 
                    name="code_cours" 
                    placeholder="Entrer le code cours" 
                    value="<?= htmlspecialchars($code_cours ?? '') ?>"
                    required>
                
                <input 
                    type="text" 
                    name="nom_cours" 
                    placeholder="Entrer le nom du cours" 
                    value="<?= htmlspecialchars($nom_cours ?? '') ?>"
                    required >
                
                <input 
                    type="text" 
                    name="description" 
                    placeholder="Entrer la description du cours" 
                    value="<?= htmlspecialchars($description ?? '') ?>"
                    required >

                
                <input 
                    type="submit" 
                    value="Ajouter" 
                    name="add">
            </form>
        </div>
    </section>
</body>
</html>