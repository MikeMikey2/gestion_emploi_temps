<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include 'ADMIN/con_dbb.php';
if(isset($_POST['add'])){
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $mdp = password_hash($_POST['mdp'], PASSWORD_BCRYPT);

    $stmt = $con->prepare("INSERT INTO PERSONNE(nom, prenom, email, mot_de_passe, enseignant) VALUES (?, ?, ?, ?, 1)");
    $stmt->bind_param("ssss", $nom, $prenom, $email, $mdp);
    
    try {
        $stmt->execute();
        $reponse_enseignant = ["type" => "success", "text" => "Enseignant ajouté avec succès."];
    } catch (mysqli_sql_exception $e) {
        if ($e->getCode() == 1062) {
            $reponse_enseignant = ["type" => "error", "text" => "Cet email est déjà utilisé."];
        } else {
            $reponse_enseignant = ["type" => "error", "text" => "Erreur : " . $e->getMessage()];
        }
    }
}

if(isset($_POST['adds'])){
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $mdp = password_hash($_POST['mdp'], PASSWORD_BCRYPT); 
    $filiere = $_POST['filiere'];

    $stmt = $con->prepare("INSERT INTO PERSONNE(nom, prenom, email, mot_de_passe, enseignant, filiere) VALUES (?, ?, ?, ?, 0, ?)");
    $stmt->bind_param("sssss", $nom, $prenom, $email, $mdp, $filiere);
    try {
        $stmt->execute();
        $reponse_etudiant = ["type" => "success", "text" => "Étudiant ajouté avec succès."];
    } catch (mysqli_sql_exception $e) {
        if ($e->getCode() == 1062) {
            $reponse_etudiant = ["type" => "error", "text" => "Cet email est déjà utilisé."];
        } else {
            $reponse_etudiant = ["type" => "error", "text" => "Erreur : " . $e->getMessage()];
        }
    }
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="style/connexion.css">
</head>
<body>
    <section class="inscr-section">
        <a href="index.php" class="back-link">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
            Retour à l'accueil
        </a>
        <div class="manage-tabs">
            <button class="tab-btn active" data-tab="teachers">Enseignants</button>
            <button class="tab-btn" data-tab="students">Étudiants</button>
        </div>
        <div class="tab-content active" id="teachers">
            <h1>Inscription d'un enseignant</h1>
            <?php if(isset($reponse_enseignant)): ?>
                <div class="msg <?= $reponse_enseignant['type'] === 'success' ? 'msg-success' : 'msg-error' ?>">
                    <?php if($reponse_enseignant['type'] === 'success'): ?>
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    <?php else: ?>
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    <?php endif; ?>
                    <span><?= htmlspecialchars($reponse_enseignant['text']) ?></span>
                </div>
            <?php endif; ?>
           <form action="#" method="post">
                <input type="text" name="nom" placeholder="Entrer votre nom" required>
                <input type="text" name="prenom" placeholder="Entrer votre prénom" required>
                <input type="text" name="email" placeholder="Entrer votre email" required>
                <input type="password" name="mdp" placeholder="Entrer le mot de passe" required>
                <input type="submit" name="add" value="S'inscrire">
           </form>
        </div>
        <div class="tab-content" id="students">
            <h1>Inscription d'un étudiant</h1>
            <?php if(isset($reponse_etudiant)): ?>
                <div class="msg <?= $reponse_etudiant['type'] === 'success' ? 'msg-success' : 'msg-error' ?>">
                    <?php if($reponse_etudiant['type'] === 'success'): ?>
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    <?php else: ?>
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    <?php endif; ?>
                    <span><?= htmlspecialchars($reponse_etudiant['text']) ?></span>
                </div>
            <?php endif; ?>
            <form action="#" method="post">
                <input type="text" name="nom" placeholder="Entrer votre nom" required>
                <input type="text" name="prenom" placeholder="Entrer votre prénom" required>
                <input type="text" name="email" placeholder="Entrer votre email" required>
                <input type="password" name="mdp" placeholder="Entrer le mot de passe" required>
                <select name="filiere" required>
                                <option value="IGL1">IGL1</option>
                                <option value="IGL2">IGL2</option>
                                <option value="BAT1">BAT1</option>
                                <option value="BAT2">BAT2</option>
                                <option value="ELT1">ELT1</option>
                                <option value="ELT2">ELT2</option>
                                <option value="FCL1">FCL1</option>
                                <option value="FCL2">FCL2</option>
                                <option value="GTO1">GTO1</option>
                                <option value="GTO2">GTO2</option>
                                <option value="IIA1">IIA1</option>
                                <option value="IIA2">IIA2</option>
                                <option value="IWD1">IWD1</option>
                                <option value="IWD2">IWD2</option>
                                <option value="MAB1">MAB1</option>
                                <option value="MAB2">MAB2</option>
                                <option value="MAVA1">MAVA1</option>
                                <option value="MAVA2">MAVA2</option>
                                <option value="RES1">RES1</option>
                                <option value="RES2">RES2</option>
                                <option value="2ndeC">2ndeC</option>
                                <option value="1ereC">1ereC</option>
                                <option value="TC">TC</option>
                                <option value="TEL1">TEL1</option>
                                <option value="TEL2">TEL2</option>
                </select>
                <input type="submit" name="adds" value="S'inscrire">
            </form>
        </div>
        <script>
            // Onglet actif après soumission
            const activeTab = '<?= isset($reponse_etudiant) ? "students" : "teachers" ?>';

            document.addEventListener('DOMContentLoaded', function() {
                // Initialise tous les onglets cachés
                document.querySelectorAll('.tab-content').forEach(c => {
                    c.classList.remove('active');
                    c.style.display = 'none';
                });
                // Active le bon onglet selon la soumission
                showTab(activeTab);
                document.querySelectorAll('.tab-btn').forEach(btn => {
                    if (btn.getAttribute('data-tab') === activeTab) {
                        btn.classList.add('active');
                    } else {
                        btn.classList.remove('active');
                    }
                    btn.addEventListener('click', function() {
                        showTab(this.getAttribute('data-tab'));
                        document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
                        this.classList.add('active');
                    });
                });
            });

            function showTab(tabName) {
                document.querySelectorAll('.tab-content').forEach(c => {
                    c.classList.remove('active');
                    c.style.display = 'none';
                });
                const tab = document.getElementById(tabName);
                if (tab) { tab.classList.add('active'); tab.style.display = 'block'; }
            }
        </script>
    </section>
</body>
</html>