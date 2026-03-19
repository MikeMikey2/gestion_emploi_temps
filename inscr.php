<?php 
include 'ADMIN/con_dbb.php';
if(isset($_POST['add'])){
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $mdp = $_POST['mdp'];
    $date_embauche = $_POST['date_embauche'];
    $filiere = $_POST['filiere'];

    $stmt = $conn->prepare("INSERT INTO PERSONNE(nom, prenom, email, mot_de_passe, enseignant, date_inscription) VALUES (?, ?, ?, ?, 1, ?)");
    $stmt->bind_param("sssss", $nom, $prenom, $email, $mdp, $date_embauche);
    $stmt->execute();
    if($stmt->affected_rows > 0){   
        echo "Enseignant ajouté avec succès.";
    } else {
        echo "Erreur: " . mysqli_error($conn);
    }
}
if(isset($_POST['adds'])){
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $mdp = $_POST['mdp'];
    $filiere = $_POST['filiere'];
    $date_entree = $_POST['date_entree'];

    $stmt = $conn->prepare("INSERT INTO PERSONNE(nom, prenom, email, mot_de_passe, enseignant,filiere, date_inscription) VALUES (?, ?, ?, ?, 0, ?, ?)");
    $stmt->bind_param("sssss", $nom, $prenom, $email, $mdp, $filiere, $date_entree);
    $stmt->execute();
    if($stmt->affected_rows > 0){
        echo "Etudiant ajouté avec succès.";
    } else {
        echo "Erreur: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style/style2.css">
</head>
<body>
    <section>
        <div class="manage-tabs">
            <button class="tab-btn active" data-tab="teachers">Enseignants</button>
            <button class="tab-btn" data-tab="students">Étudiants</button>
        </div>
        <div class="tab-content active" id="teachers">
            <h1>Inscription d'un enseignant</h1>
           <form action="#" method="post">
                 <input type="text" name="nom" placeholder="Entrer votre nom">
                 <input type="text" name="prenom" placeholder="Entrer votre prenom">
                 <input type="text" name="email" placeholder="Entrer votre emal">
                 <input type="text" name="mdp" placeholder="Entrer le mot de passe">
                 <input type="date" name="date_embauche" placeholder="Entrer votre date d'embauche">
                 <input type="submit" name="add" value="S'inscrire">
           </form>
        </div>
        <div class="tab-content" id="students">
            <h1>Inscription d'un etudiant</h1>
            <form action="#" method="post">
                <input type="text" name="nom" placeholder="Entrer votre nom">
                 <input type="text" name="prenom" placeholder="Entrer votre prenom">
                 <input type="text" name="email" placeholder="Entrer votre emal">
                 <input type="text" name="mdp" placeholder="Entrer le mot de passe">
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