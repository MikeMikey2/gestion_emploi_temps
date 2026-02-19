<?php
try {
    $conn = new PDO("mysql:host=localhost;dbname=emploi", "phpmyadmin", "mbele2.0");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Erreur de connexion: " . $e->getMessage());
}

if(isset($_POST['add'])) {
    $code_cours = $_POST['code_cours'];
    $nom_cours = $_POST['nom_cours'];
    $description = $_POST['description'];
    
    // Vérifier que les champs ne sont pas vides
    if(empty($code_cours) || empty($nom_cours) || empty($description)) {
        die("Erreur: Tous les champs sont obligatoires");
    }
    
    try {
        // ERREUR CORRIGÉE: INSERT n'utilise pas WHERE
        // Il y avait 6 placeholders (?) mais seulement 4 valeurs
        $stmt = $conn->prepare("INSERT INTO COURS(code_cours, nom_cours, description) VALUES(?, ?, ?)");
        
        // IMPORTANT: Hasher le mot de passe avant de l'enregistrer
        $mdp_hash = password_hash($mdp, PASSWORD_DEFAULT);
        
        if($stmt->execute([$code_cours, $nom_cours, $description])) {
            echo "Inscription réussie";
        } else {
            echo "Erreur lors de l'exécution";
            print_r($stmt->errorInfo());
        }
    } catch(PDOException $e) {
        echo "Erreur SQL: " . $e->getMessage();
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
        </ul>
    </nav>
    <section>
        <div class="teacher">
            <h1>Ajouter un Cour</h1>
            <form action="" method="POST" novalidate>
                <input 
                    type="text" 
                    name="code_cours" 
                    placeholder="Entrer le code_cours" 
                    required>
                
                <input 
                    type="text" 
                    name="nom_cours" 
                    placeholder="Entrer le nom_cours" 
                    required >
                
                <input 
                    type="text" 
                    name="description" 
                    placeholder="Entrer la description du cours" 
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