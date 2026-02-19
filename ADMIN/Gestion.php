<?php
include_once "con_dbb.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../style/style2.css">
</head>
<body>
    <div class="Gtitre"><b>GESTION DES UTILISATEURS</b></div>
    <nav>
       <h5 class="menu">MENU</h5>
        <ul class="nav-list">
                <li><a href="tableau.php" class="<?= (basename($_SERVER['PHP_SELF'])=='tableau.php') ? 'nav-active' : '' ?>"><img src="../icons/table.png" alt="20" width="30">Tableau de bord</a></li>
                <li><a href="Gestion.php" class="<?= (basename($_SERVER['PHP_SELF'])=='Gestion.php') ? 'nav-active' : '' ?>"><img src="../icons/per.png" alt="20" width="30">Gestion</a></li>
                <li><a href="Emploi.php" class="<?= (basename($_SERVER['PHP_SELF'])=='Emploi.php') ? 'nav-active' : '' ?>"><img src="../icons/evenement.png" alt="20" width="30"> Emploi du temps</a></li>
                <li><a href="Requetes.php" class="<?= (basename($_SERVER['PHP_SELF'])=='Requetes.php') ? 'nav-active' : '' ?>"><img src="../icons/message.jpeg" alt="20" width="30">Requetes<span class="badge"><?php echo mysqli_num_rows(mysqli_query($con, "SELECT * FROM REQUETE WHERE statut='en_attente'")); ?></span></a></li>
            </ul>
    </nav>
    <section>
        <div class="manage-tabs">
            <button class="tab-btn active" data-tab="teachers">Enseignants</button>
            <button class="tab-btn" data-tab="students">Étudiants</button>
            <button class="tab-btn" data-tab="courses">Cours</button>
        </div>
        <div class="tab-content active" id="teachers">
            <div class="user-list">
                <div class="user-card">
                    <div class="liste">
                        <h1>Liste des Gestion</h1>
                        <p>liste de tous les Gestion enregistres dans la base de donnees.</p>
                        <form action="../edit/add_prof.php" method="POST">
                            <input type="submit" value="Ajouter" ">
                        </form>
                        <?php 
                        $stm=mysqli_query($con," SELECT * FROM PERSONNE WHERE enseignant=1");
                        $prof=$stm->fetch_all(MYSQLI_ASSOC);
                        ?>
                    </div>
                    <div class="rech">
                        <input type="text" class="search" placeholder="Entrer le nom ">
                    </div>
                    <table>
                        <tr>
                            <th>Nom</th>
                            <th>Prenom</th>
                            <th>Adresse mail</th>
                            <th>Action</th>
                        </tr>
                        <?php
                        foreach($prof as $p):
                        ?>
                        <tr>
                            <td><?=htmlspecialchars($p['nom'])?></td>
                            <td><?=htmlspecialchars($p['prenom'])?></td>
                            <td><?=htmlspecialchars($p['email'])?></td>
                            <td><a href="../edit/modif.php?id=<?= $p['id_personne'] ?>">
                                <img src="../icons/modify.jpeg"  width="30"></a> 
                            <a href="../edit/delete.php?id=<?= $p['id_personne'] ?>" onclick="return confirm('Êtes-vous sûr?')"><img src="../icons/delete.png" alt="50" width="30"></a>
                        </td>
                        </tr>
                        <?php 
                        endforeach;
                        ?>
                    </table>
                </div>
            </div>
        </div>
        <div class="tab-content" id="students">
            <div class="users-list">
                <div class="user-card">
                    <div class="liste">
                        <h1>Liste des Étudiants</h1>
                        <p>Liste de tous les étudiants enregistrés dans la base de données.</p>
                        <form action="../edit/inscr.php" method="POST">
                            <input type="submit" value="Ajouter" >
                        </form>
                    </div>
                    <div class="rech">
                        <input type="text" class="search" placeholder="Entrer le nom ">
                    </div>
                    <?php $stm2=mysqli_query($con," SELECT * FROM PERSONNE WHERE enseignant=0");
                          $etudiant=$stm2->fetch_all(MYSQLI_ASSOC);
                    ?>
                    <table>
                        <tr>
                            <th>Nom</th>
                            <th>Prenom</th>
                            <th>Adresse mail</th>
                            <th>Action</th>
                        </tr>
                        <?php
                        foreach($etudiant as $etud):
                        ?>
                        <tr>
                            <td><?=htmlspecialchars($etud['nom'])?></td>
                            <td><?=htmlspecialchars($etud['prenom'])?></td>
                            <td><?=htmlspecialchars($etud['email'])?></td>
                            <td><a href="../edit/modif.php?id=<?= htmlspecialchars($etud['id_personne']) ?>"><img src="../icons/modify.jpeg"  width="30"></a> 
                             
                            <a href="../edit/delete.php?id=<?= htmlspecialchars($etud['id_personne']) ?>" onclick="return confirm('Êtes-vous sûr?')"><img src="../icons/delete.png" alt="50" width="30"></a></td>
                        </tr>
                        <?php 
                        endforeach;
                        ?>
                    </table>
                </div>
            </div>
        </div>
        
        <div class="tab-content" id="courses">
            <div class="courses-grid">
                <div class="user-card">
                    <div class="liste">
                        <h1>Liste des Cours</h1>
                        <p>Liste de tous les cours enregistrés dans la base de données.</p>
                        <form action="../edit/add_cour.php" method="POST">
                            <input type="submit" value="Ajouter" >
                        </form>
                    </div>
                    <div class="rech">
                        <input type="text" class="search" placeholder="Entrer le nom du cours ">
                    </div>
                    <?php
                    $stm3=mysqli_query($con,"SELECT * FROM COURS ");
                    $cours=$stm3->fetch_all(MYSQLI_ASSOC);
                    ?>
                    <table>
                        <tr>
                            <th>Code</th>
                            <th>Nom</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                        <?php
                        foreach($cours as $cour):
                        ?>
                        <tr>
                            <td><?= htmlspecialchars($cour['code_cours'])?></td>
                            <td><?= htmlspecialchars($cour['nom_cours'])?></td>
                            <td><?= htmlspecialchars($cour['description'])?></td>
                            <td><a href="../edit/cour.php?id=<?= htmlspecialchars($cour['id_cours']) ?>"><img src="../icons/modify.jpeg"  width="30"></a> 
                    
                            <a href="../edit/delete_cours.php?id=<?= htmlspecialchars($cour['id_cours']) ?>" onclick="return confirm('Êtes-vous sûr?')"><img src="../icons/delete.png" alt="50" width="30"></a></td>
                        </tr>
                        <?php
                        endforeach;
                        ?>
                    </table>
                </div>
            </div>
        </div>
    </section>
    
    <script>
        // Gestion des onglets pour afficher les données filtrées
        document.addEventListener('DOMContentLoaded', function() {
            // Masquer tous les onglets sauf le premier au chargement
            const allTabContents = document.querySelectorAll('.tab-content');
            allTabContents.forEach((content, index) => {
                if (index === 0) {
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

        // Fonction de recherche dynamique
        function initSearch() {
            const searchInputs = document.querySelectorAll('.search');
            
            searchInputs.forEach(input => {
                // Trouver le tableau parent le plus proche
                const tableContainer = input.closest('.tab-content');
                const table = tableContainer?.querySelector('table');
                
                if (!input || !table) return;

                // Fonction pour effectuer la recherche
                function performSearch(query) {
                    const searchTerm = query.trim().toLowerCase();
                    const rows = table.querySelectorAll('tbody tr') || table.querySelectorAll('tr:not(:first-child)');
                    
                    let matchCount = 0;
                    
                    rows.forEach(row => {
                        let isVisible = false;
                        
                        // Si la recherche est vide, afficher toutes les lignes
                        if (searchTerm === '') {
                            isVisible = true;
                        } else {
                            // Chercher dans tous les cellules sauf la dernière (Actions)
                            const cells = Array.from(row.cells);
                            isVisible = cells.some((cell, index) => {
                                // Ignorer la colonne Actions (généralement la dernière)
                                if (index === cells.length - 1) return false;
                                
                                const cellText = cell.textContent.trim().toLowerCase();
                                return cellText.includes(searchTerm);
                            });
                        }
                        
                        row.style.display = isVisible ? '' : 'none';
                        if (isVisible) matchCount++;
                    });
                }

                // Gestion de l'événement "input" avec debounce
                let searchTimeout;
                input.addEventListener('input', (e) => {
                    clearTimeout(searchTimeout);
                    searchTimeout = setTimeout(() => {
                        performSearch(e.target.value);
                    }, 200);
                });

                // Gestion de la touche Entrée
                input.addEventListener('keydown', (e) => {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        clearTimeout(searchTimeout);
                        performSearch(input.value);
                    }
                });
            });
        }

        // Initialiser la recherche après le chargement du DOM
        document.addEventListener('DOMContentLoaded', initSearch);

        // Mettre en surbrillance le lien de navigation correspondant à la page courante
        function highlightActiveNav() {
            const currentFile = window.location.pathname.split('/').pop();
            const navLinks = document.querySelectorAll('nav .nav-list a');
            navLinks.forEach(a => {
                const href = a.getAttribute('href');
                if (!href) return;
                // Comparer le nom de fichier (Gestion.php === Gestion.php)
                if (href === currentFile || (currentFile && currentFile.indexOf(href) !== -1)) {
                    a.classList.add('nav-active');
                }
            });
        }

        document.addEventListener('DOMContentLoaded', highlightActiveNav);
    </script>
</body>
</html>