<?php
try{
    $conn = new PDO("mysql:host=localhost;dbname=emploi", "phpmyadmin", "mbele2.0");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e){
    die("Erreur de connexion: " . $e->getMessage());
}

$message = null;
$message_type = null;

if(isset($_POST['add'])){
    $nom = $_POST['nom'] ?? '';
    $prenom = $_POST['prenom'] ?? '';
    $email = $_POST['email'] ?? '';
    $mot_de_passe = $_POST['mot_de_passe'] ?? '';
    
    // Vérifier que les champs ne sont pas vides
    if(empty($nom) || empty($prenom) || empty($email) || empty($mot_de_passe)){
        $message = "Tous les champs sont obligatoires";
        $message_type = "error";
    } else {
        try{
            $stmt = $conn->prepare("INSERT INTO PERSONNE(nom, prenom, email, mot_de_passe,enseignant) VALUES(?, ?, ?, ?,0)");
            $mdp_hash = password_hash($mot_de_passe, PASSWORD_DEFAULT);
            if($stmt->execute([$nom, $prenom, $email, $mdp_hash])){
                $message = "Étudiant ajouté avec succès";
                $message_type = "success";
                $nom = $prenom = $email = $mot_de_passe = '';
            }else{
                $message = "Erreur lors de l'ajout de l'étudiant";
                $message_type = "error";
            }
        }
        catch(PDOException $e){
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
            <li><a href="../ADMIN/tableau.php" class="<?= (basename($_SERVER['PHP_SELF'])=='tableau.php') ? 'nav-active' : '' ?>"><img src="../icons/tableau.png" alt="20" width="30">Tableau de bord</a></li>
            <li><a href="../ADMIN/Gestion.php" class="<?= (basename($_SERVER['PHP_SELF'])=='Gestion.php') ? 'nav-active' : '' ?>"><img src="../icons/prof.png" alt="20" width="30">Gestion</a></li>
            <li><a href="../ADMIN/Emploi.php" class="<?= (basename($_SERVER['PHP_SELF'])=='Emploi.php') ? 'nav-active' : '' ?>"><img src="../icons/emp.png" alt="20" width="30"> Emploi du temps</a></li>
            <li><a href="../ADMIN/Requetes.php" class="<?= (basename($_SERVER['PHP_SELF'])=='Requetes.php') ? 'nav-active' : '' ?>"><img src="../icons/message.jpeg" alt="20" width="30">Requetes<span class="badge"><?php $pending = $conn->query("SELECT COUNT(*) FROM REQUETE WHERE statut='en_attente'")->fetchColumn(); echo $pending; ?></span></a></li>
        </ul>
    </nav>
    <section>
        <div class="teacher">
            <h1>Ajouter un Étudiant</h1>
            <?php if($message): ?>
                <div class="form-message form-message-<?= $message_type ?>">
                    <i class="fas fa-<?= $message_type === 'success' ? 'check-circle' : ($message_type === 'error' ? 'exclamation-circle' : 'info-circle') ?>"></i>
                    <span><?= htmlspecialchars($message) ?></span>
                </div>
            <?php endif; ?>
            <form action="" method="POST" novalidate>
                <input 
                    type="text" 
                    name="nom" 
                    placeholder="Entrer le nom" 
                    value="<?= htmlspecialchars($nom ?? '') ?>"
                    required>
                
                <input 
                    type="text" 
                    name="prenom" 
                    placeholder="Entrer le prénom" 
                    value="<?= htmlspecialchars($prenom ?? '') ?>"
                    required >
                
                <input 
                    type="email" 
                    name="email" 
                    placeholder="Entrer l'email" 
                    value="<?= htmlspecialchars($email ?? '') ?>"
                    required >
                
                <div class="password-field">
                    <input 
                        type="password" 
                        id="passwordInput"
                        name="mot_de_passe" 
                        placeholder="Entrer le mot de passe" 
                        required >
                    <button type="button" class="toggle-password" onclick="togglePassword()">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
                
                <input 
                    type="submit" 
                    value="Ajouter" 
                    name="add">
            </form>
        </div>
    </section>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('passwordInput');
            const toggleBtn = document.querySelector('.toggle-password i');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleBtn.classList.remove('fa-eye');
                toggleBtn.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleBtn.classList.remove('fa-eye-slash');
                toggleBtn.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>