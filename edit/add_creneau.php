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
    $date = $_POST['date'] ?? '';
    $heure_debut = $_POST['heure_debut'] ?? '';
    $heure_fin = $_POST['heure_fin'] ?? '';
    $salle = $_POST['salle'] ?? '';
    $id_cours = $_POST['id_cours'] ?? '';
    $id_admin = $_POST['id_admin'] ?? '';
    $code_cours = $_POST['code_cours'] ?? '';
    $filiere = $_POST['filiere'] ?? '';
    $id_personne = $_POST['id_personne'] ?? '';
    
    // Vérifier que les champs ne sont pas vides
    if(empty($date) || empty($heure_debut) || empty($heure_fin) || empty($salle) || empty($id_cours) || empty($id_admin) || empty($code_cours) || empty($filiere) || empty($id_personne)) {
        $message = "Tous les champs sont obligatoires";
        $message_type = "error";
    } else {
        try {
            $stmt = $conn->prepare("INSERT INTO CRENEAU(date, heure_debut, heure_fin, salle, id_cours, id_admin, code_cours, filiere, id_personne) 
                                    VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)");
            if($stmt->execute([$date, $heure_debut, $heure_fin, $salle, $id_cours, $id_admin, $code_cours, $filiere, $id_personne])) {
                $message = "Créneau ajouté avec succès";
                $message_type = "success";
                $date = $heure_debut = $heure_fin = $salle = $id_cours = $id_admin = $code_cours = $filiere = $id_personne = '';
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
        </ul>
    </nav>
    <section>
        <div class="teacher">
            <h1>Ajouter un Créneau</h1>
            <?php if($message): ?>
                <div class="form-message form-message-<?= $message_type ?>">
                    <i class="fas fa-<?= $message_type === 'success' ? 'check-circle' : 'exclamation-circle' ?>"></i>
                    <span><?= htmlspecialchars($message) ?></span>
                </div>
            <?php endif; ?>
            <form action="" method="POST" novalidate>
                <input type="text" name="date" placeholder="Date" value="<?= htmlspecialchars($date ?? '') ?>" required>
                <input type="text" name="heure_debut" placeholder="Heure de début" value="<?= htmlspecialchars($heure_debut ?? '') ?>" required>
                <input type="text" name="heure_fin" placeholder="Heure de fin" value="<?= htmlspecialchars($heure_fin ?? '') ?>" required>
                <input type="text" name="salle" placeholder="Salle" value="<?= htmlspecialchars($salle ?? '') ?>" required>
                <input type="text" name="id_cours" placeholder="ID cours" value="<?= htmlspecialchars($id_cours ?? '') ?>" required>
                <input type="text" name="id_admin" placeholder="ID admin" value="<?= htmlspecialchars($id_admin ?? '') ?>" required>
                <input type="text" name="code_cours" placeholder="Code cours" value="<?= htmlspecialchars($code_cours ?? '') ?>" required>
                <input type="text" name="filiere" placeholder="Filière" value="<?= htmlspecialchars($filiere ?? '') ?>" required>
                <input type="text" name="id_personne" placeholder="ID professeur" value="<?= htmlspecialchars($id_personne ?? '') ?>" required>

                <input type="submit" value="Ajouter" name="add">
            </form>
        </div>
    </section>
</body>
</html>