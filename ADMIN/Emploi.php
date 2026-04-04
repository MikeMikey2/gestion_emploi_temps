<?php
//connecter a la base de donnees
        include_once "conn_dbb.php";
        include_once "../icons/icons.php";
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Emploi du temps</title>
    <link rel="stylesheet" href="../style/style2.css">
</head>
<body>
    <div class="Gtitre"><b>GESTION DE L'EMPLOI DU TEMPS</b></div>
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
        <h1>Liste d'emploi du temps</h1>
        <div class="choix">
            <p>Voici notre emploi du temps !</p>
        </div>
    </section>
    <section>
        <div class="recherche">
            <form action="../edit/add_creneau.php" method="POST" novalidate>
                <input 
                    type="text" 
                    class="search" 
                    id="search" 
                    placeholder="Rechercher une classe, date, code ou salle..."
                    autocomplete="off">
                <small id="searchMessage" aria-live="polite"></small>
                <input 
                    type="submit" 
                    value="+ Ajouter un créneau" 
                    name="ajout"
                    class="btn-add">
            </form>
        </div>
        <?php
        
        $stm=mysqli_query($con," SELECT c.*,co.code_cours FROM CRENEAU c JOIN COURS co ON c.id_cours = co.id_cours");
        $cours=$stm->fetch_all(MYSQLI_ASSOC);
        ?>
        <div class="table-wrapper">
        <table>
            <tr>
            <th>Date</th>
            <th>Heure début</th>
            <th>Code cours</th>
            <th>Classe</th>
            <th>Salle</th>
            <th>Heure fin</th>
            <th>Id prof</th>
            <th>Action</th>
        </tr>  
        <?php foreach($cours as $cour): ?>
         <tr>
            <td><?=htmlspecialchars($cour['date']) ?></td>
            <td><?=htmlspecialchars($cour['heure_debut']) ?></td>
            <td><?=htmlspecialchars($cour['code_cours']) ?></td>
            <td><?=htmlspecialchars($cour['filiere']) ?></td>
            <td><?=htmlspecialchars($cour['salle']) ?></td>
            <td><?=htmlspecialchars($cour['heure_fin']) ?></td>
            <td><?= htmlspecialchars($cour['id_personne']) ?></td>
            <td>
                <a href="../edit/edit_creneau.php?id=<?= $cour['id_creneau'] ?>" class="action-btn edit" title="Modifier"><?= svg_icon('edit', 18) ?></a>
                <a href="../edit/delete_creneau.php?id=<?= $cour['id_creneau'] ?>" class="action-btn del" title="Supprimer" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce créneau ?')"><?= svg_icon('delete', 18) ?></a>
            </td>
        </tr>   
        <?php endforeach; ?>
    </div>
    </section>
        <script>
        document.addEventListener('DOMContentLoaded', function () {
            const input = document.getElementById('search');
            const msg = document.getElementById('searchMessage');
            const table = document.querySelector('table');
            if (!table) return;
            
            const allRows = Array.from(table.querySelectorAll('tbody tr'));
            if (allRows.length === 0) {
                allRows.push(...Array.from(table.querySelectorAll('tr')).slice(1));
            }

            const rowsData = allRows.map(row => ({
                element: row,
                classe: row.cells[3] ? row.cells[3].textContent.trim().toLowerCase() : '',
                date: row.cells[0] ? row.cells[0].textContent.trim().toLowerCase() : '',
                code: row.cells[2] ? row.cells[2].textContent.trim().toLowerCase() : '',
                salle: row.cells[4] ? row.cells[4].textContent.trim().toLowerCase() : ''
            }));

            function debounce(fn, wait) {
                let timeout;
                return (...args) => {
                    clearTimeout(timeout);
                    timeout = setTimeout(() => fn(...args), wait);
                };
            }

            function filterByClass(query) {
                const searchTerm = query.trim().toLowerCase();
                
                if (searchTerm === '') {
                    rowsData.forEach(({ element }) => {
                        element.style.display = '';
                        element.classList.remove('highlight-row');
                    });
                    msg.textContent = '';
                    return;
                }

                let visibleCount = 0;

                rowsData.forEach(({ element, classe, date, code, salle }) => {
                    const matchesSearch = 
                        classe.includes(searchTerm) ||
                        date.includes(searchTerm) ||
                        code.includes(searchTerm) ||
                        salle.includes(searchTerm);

                    if (matchesSearch) {
                        element.style.display = '';
                        element.classList.add('highlight-row');
                        visibleCount++;
                    } else {
                        element.style.display = 'none';
                        element.classList.remove('highlight-row');
                    }
                });

                if (visibleCount === 0) {
                    msg.textContent = `Aucun résultat pour "${query}"`;
                    msg.style.color = '#f56565';
                } else {
                    msg.textContent = `${visibleCount} résultat(s) trouvé(s)`;
                    msg.style.color = '#48bb78';
                }
            }

            const debouncedFilter = debounce(filterByClass, 150);
            input.addEventListener('input', (e) => { debouncedFilter(e.target.value); });
            input.addEventListener('keydown', (e) => {
                if (e.key === 'Enter') { e.preventDefault(); filterByClass(input.value); }
                if (e.key === 'Escape') { input.value = ''; filterByClass(''); input.focus(); }
            });
            input.focus();
        });

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