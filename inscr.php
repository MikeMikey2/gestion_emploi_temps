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
    $date_embauche = $_POST['date_embauche'];

    $stmt = $con->prepare("INSERT INTO PERSONNE(nom, prenom, email, mot_de_passe, enseignant, date_inscription) VALUES (?, ?, ?, ?, 1, ?)");
    $stmt->bind_param("sssss", $nom, $prenom, $email, $mdp, $date_embauche);
    
    try {
        $stmt->execute();
        $reponse_enseignant = "Enseignant ajouté avec succès.";
    } catch (mysqli_sql_exception $e) {
        if ($e->getCode() == 1062) { // Code MySQL pour doublon
            $reponse_enseignant = " Cet email est déjà utilisé.";
        } else {
            $reponse_enseignant = " Erreur : " . $e->getMessage();
        }
    }
}

if(isset($_POST['adds'])){
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $mdp = password_hash($_POST['mdp'], PASSWORD_BCRYPT); 
    $filiere = $_POST['filiere'];
    $date_entree = $_POST['date_entree'];

    $stmt = $con->prepare("INSERT INTO PERSONNE(nom, prenom, email, mot_de_passe, enseignant, filiere, date_inscription) VALUES (?, ?, ?, ?, 0, ?, ?)");
    $stmt->bind_param("ssssss", $nom, $prenom, $email, $mdp, $filiere, $date_entree);
       try {
        $stmt->execute();
        $reponse_etudiant = "Étudiant ajouté avec succès.";
    } catch (mysqli_sql_exception $e) {
        if ($e->getCode() == 1062) { // Code MySQL pour doublon
            $reponse_etudiant = " Cet email est déjà utilisé.";
        } else {
            $reponse_etudiant = " Erreur : " . $e->getMessage();
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style/connexion.css">
</head>
<body>
    <section>
        <div class="manage-tabs">
            <button class="tab-btn active" data-tab="teachers">Enseignants</button>
            <button class="tab-btn" data-tab="students">Étudiants</button>
        </div>
        <div class="tab-content active" id="teachers">
            <h1>Inscription d'un enseignant</h1>
            <?php if(isset($reponse_enseignant)): ?>
                <p><?php echo $reponse_enseignant; ?></p>
            <?php endif; ?>
           <form action="#" method="post">
                 <input type="text" name="nom" placeholder="Entrer votre nom">
                 <input type="text" name="prenom" placeholder="Entrer votre prenom">
                 <input type="text" name="email" placeholder="Entrer votre email">
                 <input type="password" name="mdp" placeholder="Entrer le mot de passe">
                 <input type="date" name="date_embauche" placeholder="Entrer votre date d'embauche">
                 <input type="submit" name="add" value="S'inscrire">
           </form>
        </div>
        <div class="tab-content" id="students">
            <h1>Inscription d'un etudiant</h1>
            <?php if(isset($reponse_etudiant)): ?>
                <p><?php echo $reponse_etudiant; ?></p>
            <?php endif; ?>
            <form action="#" method="post">
                <input type="text" name="nom" placeholder="Entrer votre nom">
                 <input type="text" name="prenom" placeholder="Entrer votre prenom">
                 <input type="text" name="email" placeholder="Entrer votre email">
                 <input type="password" name="mdp" placeholder="Entrer le mot de passe">
                 <input type="date" name="date_entree" placeholder="Entrer votre date d'entrée">
                 <input type="text" name="filiere" placeholder="Entrer votre filiere">
                 <input type="submit" name="adds" value="S'inscrire">
            </form>
        </div>
        <script>
            // Gestion des onglets pour afficher les données filtrées
        document.addEventListener('DOMContentLoaded', function() {
            // Masquer tous les onglets sauf le premier au chargement
            const allTabContents = document.querySelectorAll('.tab-content');
            allTabContents.forEach((content, logout) => {
                if (logout === 0) {
                    content.classList.add('active');
                    content.style.display = 'block';
                } else {
                    content.classList.remove('active');
                    content.style.display = 'none';
                }
            });
            
            // Récupérer tous les boutons d'onglet
            const tabButtons = document.querySelectorAll('.tab-btn');
            
            // Ajouter un événement click à chaque bouton
            tabButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Récupérer l'attribut data-tab du bouton cliqué
                    const tabName = this.getAttribute('data-tab');
                    
                    // Afficher uniquement le contenu sélectionné
                    showTab(tabName);
                    
                    // Mettre à jour le style du bouton actif
                    tabButtons.forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');
                });
            });
        });

        // Fonction pour afficher l'onglet sélectionné
        function showTab(tabName) {
            // Masquer tous les onglets
            const allTabContents = document.querySelectorAll('.tab-content');
            allTabContents.forEach(content => {
                content.classList.remove('active');
                content.style.display = 'none';
            });
            
            // Afficher l'onglet sélectionné
            const selectedTab = document.getElementById(tabName);
            if (selectedTab) {
                selectedTab.classList.add('active');
                selectedTab.style.display = 'block';
            }
        }
        </script>
    </section>
</body>
</html>