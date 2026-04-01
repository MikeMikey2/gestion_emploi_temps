<?php
include_once "con_dbb.php";
include_once "../icons/icons.php";
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des utilisateurs</title>
    <link rel="stylesheet" href="../style/style2.css">
</head>
<body>
    <div class="Gtitre"><b>GESTION DES UTILISATEURS</b></div>
    <nav>
        <button class="nav-toggle" id="navToggle" aria-label="Menu">
            <svg class="hamburger" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
            <svg class="close-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            <span>MENU</span>
        </button>
        <h5 class="menu"><?= svg_icon('menu', 14) ?> MENU</h5>
        <ul class="nav-list" id="navList">
            <li><a href="tableau.php" class="<?= (basename($_SERVER['PHP_SELF'])=='tableau.php') ? 'nav-active' : '' ?>"><?= svg_icon('dashboard', 20) ?>Tableau de bord</a></li>
            <li><a href="Gestion.php" class="<?= (basename($_SERVER['PHP_SELF'])=='Gestion.php') ? 'nav-active' : '' ?>"><?= svg_icon('gestion', 20) ?>Gestion</a></li>
            <li><a href="Emploi.php" class="<?= (basename($_SERVER['PHP_SELF'])=='Emploi.php') ? 'nav-active' : '' ?>"><?= svg_icon('emploi', 20) ?>Emploi du temps</a></li>
            <li><a href="Requetes.php" class="<?= (basename($_SERVER['PHP_SELF'])=='Requetes.php') ? 'nav-active' : '' ?>"><?= svg_icon('requetes', 20) ?>Requêtes
                <span class="badge"><?php echo mysqli_num_rows(mysqli_query($con, "SELECT * FROM REQUETE WHERE statut='en_attente'")); ?></span>
            </a></li>
            <li><a href="profdispo.php" class="<?= (basename($_SERVER['PHP_SELF'])=='profdispo.php') ? 'nav-active' : '' ?>"><?= svg_icon('profdispo', 20) ?>Enseignants disponibles</a></li>
            <li><a href="salles_dispo.php" class="<?= (basename($_SERVER['PHP_SELF'])=='salles_dispo.php') ? 'nav-active' : '' ?>"><?= svg_icon('salles', 20) ?>Salles disponibles</a></li>
        </ul>
        <ul class="nav-footer" id="navFooter">
            <li><a href="../logout.php"><?= svg_icon('logout', 20) ?>Déconnexion</a></li>
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
                        <h1>Liste des Enseignants</h1>
                        <p>liste de tous les enseignants enregistres dans la base de donnees.</p>
                        <?php 
                        $stm=mysqli_query($con," SELECT * FROM PERSONNE WHERE enseignant=1");
                        $prof=$stm->fetch_all(MYSQLI_ASSOC);
                        ?>
                    </div>
                    <div class="rech">
                        <input type="text" class="search" placeholder="Rechercher un enseignant...">
                    </div>
                    <div class="table-wrapper">
                    <table>
                        <tr>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Adresse mail</th>
                            <th>Action</th>
                        </tr>
                        <?php foreach($prof as $p): ?>
                        <tr>
                            <td><?=htmlspecialchars($p['nom'])?></td>
                            <td><?=htmlspecialchars($p['prenom'])?></td>
                            <td><?=htmlspecialchars($p['email'])?></td>
                            <td>
                                <a href="../edit/modif.php?id=<?= $p['id_personne'] ?>" class="action-btn edit" title="Modifier"><?= svg_icon('edit', 18) ?></a>
                                <a href="../edit/delete.php?id=<?= $p['id_personne'] ?>" class="action-btn del" title="Supprimer" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet enseignant ?')"><?= svg_icon('delete', 18) ?></a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-content" id="students">
            <div class="users-list">
                <div class="user-card">
                    <div class="liste">
                        <h1>Liste des Étudiants</h1>
                        <p>Liste de tous les étudiants enregistrés dans la base de données.</p>
                    </div>
                    <div class="rech">
                        <input type="text" class="search" placeholder="Rechercher un étudiant...">
                    </div>
                    <?php $stm2=mysqli_query($con," SELECT * FROM PERSONNE WHERE enseignant=0");
                          $etudiant=$stm2->fetch_all(MYSQLI_ASSOC);
                    ?>
                    <div class="table-wrapper">
                    <table>
                        <tr>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Adresse mail</th>
                            <th>Action</th>
                        </tr>
                        <?php foreach($etudiant as $etud): ?>
                        <tr>
                            <td><?=htmlspecialchars($etud['nom'])?></td>
                            <td><?=htmlspecialchars($etud['prenom'])?></td>
                            <td><?=htmlspecialchars($etud['email'])?></td>
                            <td>
                                <a href="../edit/modif.php?id=<?= htmlspecialchars($etud['id_personne']) ?>" class="action-btn edit" title="Modifier"><?= svg_icon('edit', 18) ?></a>
                                <a href="../edit/delete.php?id=<?= htmlspecialchars($etud['id_personne']) ?>" class="action-btn del" title="Supprimer" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet étudiant ?')"><?= svg_icon('delete', 18) ?></a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                    </div>
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
                            <input type="submit" value="+ Ajouter un cours">
                        </form>
                    </div>
                    <div class="rech">
                        <input type="text" class="search" placeholder="Rechercher un cours...">
                    </div>
                    <?php
                    $stm3=mysqli_query($con,"SELECT * FROM COURS ");
                    $cours=$stm3->fetch_all(MYSQLI_ASSOC);
                    ?>
                    <div class="table-wrapper">
                    <table>
                        <tr>
                            <th>Code</th>
                            <th>Nom</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                        <?php foreach($cours as $cour): ?>
                        <tr>
                            <td><?= htmlspecialchars($cour['code_cours'])?></td>
                            <td><?= htmlspecialchars($cour['nom_cours'])?></td>
                            <td><?= htmlspecialchars($cour['description'])?></td>
                            <td>
                                <a href="../edit/cour.php?id=<?= htmlspecialchars($cour['id_cours']) ?>" class="action-btn edit" title="Modifier"><?= svg_icon('edit', 18) ?></a>
                                <a href="../edit/delete_cours.php?id=<?= htmlspecialchars($cour['id_cours']) ?>" class="action-btn del" title="Supprimer" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce cours ?')"><?= svg_icon('delete', 18) ?></a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <script>
        // Gestion des onglets pour afficher les données filtrées
        document.addEventListener('DOMContentLoaded', function() {
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
            
            const tabButtons = document.querySelectorAll('.tab-btn');
            
            tabButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const tabName = this.getAttribute('data-tab');
                    showTab(tabName);
                    tabButtons.forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');
                });
            });
        });

        function showTab(tabName) {
            const allTabContents = document.querySelectorAll('.tab-content');
            allTabContents.forEach(content => {
                content.classList.remove('active');
                content.style.display = 'none';
            });
            const selectedTab = document.getElementById(tabName);
            if (selectedTab) {
                selectedTab.classList.add('active');
                selectedTab.style.display = 'block';
            }
        }

        // Recherche dynamique
        function initSearch() {
            const searchInputs = document.querySelectorAll('.search');
            searchInputs.forEach(input => {
                const tableContainer = input.closest('.tab-content');
                const table = tableContainer?.querySelector('table');
                if (!input || !table) return;

                function performSearch(query) {
                    const searchTerm = query.trim().toLowerCase();
                    const rows = table.querySelectorAll('tbody tr') || table.querySelectorAll('tr:not(:first-child)');
                    rows.forEach(row => {
                        let isVisible = false;
                        if (searchTerm === '') {
                            isVisible = true;
                        } else {
                            const cells = Array.from(row.cells);
                            isVisible = cells.some((cell, logout) => {
                                if (logout === cells.length - 1) return false;
                                const cellText = cell.textContent.trim().toLowerCase();
                                return cellText.includes(searchTerm);
                            });
                        }
                        row.style.display = isVisible ? '' : 'none';
                    });
                }

                let searchTimeout;
                input.addEventListener('input', (e) => {
                    clearTimeout(searchTimeout);
                    searchTimeout = setTimeout(() => { performSearch(e.target.value); }, 200);
                });
                input.addEventListener('keydown', (e) => {
                    if (e.key === 'Enter') { e.preventDefault(); clearTimeout(searchTimeout); performSearch(input.value); }
                });
            });
        }

        document.addEventListener('DOMContentLoaded', initSearch);

        // Bouton toggle nav
        const navToggle = document.getElementById('navToggle');
        const navList   = document.getElementById('navList');
        const navFooter = document.getElementById('navFooter');

        navToggle.addEventListener('click', function () {
            const isOpen = navList.classList.contains('open');
            navList.classList.toggle('open', !isOpen);
            navFooter.classList.toggle('open', !isOpen);
            navToggle.classList.toggle('open', !isOpen);
        });

        navList.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', () => {
                navList.classList.remove('open');
                navFooter.classList.remove('open');
                navToggle.classList.remove('open');
            });
        });
    </script>
</body>
</html>