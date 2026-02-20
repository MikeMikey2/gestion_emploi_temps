<?php
//connecter a la base de donnees
        include_once "con_dbb.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appli</title>
    <link rel="stylesheet" href="../style/style2.css">
</head>
<body>
    <div class="Gtitre"><b>GESTION DE L'EMPLOI DU TEMPS</b></div>
      <nav>
     <h5 class="menu">MENU</h5>
         <ul class="nav-list">
            <li><a href="tableau.php" class="<?= (basename($_SERVER['PHP_SELF'])=='tableau.php') ? 'nav-active' : '' ?>"><img src="../icons/table.png" alt="20" width="30">Tableau de bord</a></li>
            <li><a href="Gestion.php" class="<?= (basename($_SERVER['PHP_SELF'])=='Gestion.php') ? 'nav-active' : '' ?>"><img src="../icons/per.png" alt="20" width="30">Gestion</a></li>
            <li><a href="Emploi.php" class="<?= (basename($_SERVER['PHP_SELF'])=='Emploi.php') ? 'nav-active' : '' ?>"><img src="../icons/evenement.png" alt="20" width="30">Emploi du temps</a></li>
            <li><a href="Requetes.php" class="<?= (basename($_SERVER['PHP_SELF'])=='Requetes.php') ? 'nav-active' : '' ?>"><img src="../icons/message.jpeg" alt="20" width="30">Requetes<span class="badge"><?php echo mysqli_num_rows(mysqli_query($con, "SELECT * FROM REQUETE WHERE statut='en_attente'")); ?></span></a></li>
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
                    id="search" 
                    placeholder="Rechercher une classe, date, code ou salle..."
                    autocomplete="off">
                <small id="searchMessage" aria-live="polite"></small>
                <input 
                    type="submit" 
                    value="Ajouter un créneau" 
                    name="ajout">
            </form>
        </div>
        <?php
        
        $stm=mysqli_query($con," SELECT * FROM CRENEAU");
        $cours=$stm->fetch_all(MYSQLI_ASSOC);
        $st = mysqli_query($con,"SELECT * FROM COURS WHERE id_cours IN (SELECT id_cours FROM CRENEAU)");
        $cre = $st->fetch_all(MYSQLI_ASSOC);
        ?>
      <table>
            <tr>
            <th>Date</th>
            <th>Heure_debut</th>
            <th>Code_cours</th>
            <th>Classe</th>
            <th>Salle</th>
            <th>Heure_fin</th>
            <th>Action</th>
        </tr>  
        <?php foreach($cours as $cour): ?>
         <tr>
            <td><?=htmlspecialchars($cour['date']) ?></td>
            <td ><?=htmlspecialchars($cour['heure_debut']) ?></td>
            <td ><?=htmlspecialchars($cour['code_cours']) ?></td>
            <td><?=htmlspecialchars($cour['filiere']) ?></td>
            <td ><?=htmlspecialchars($cour['salle']) ?></td>
            <td><?=htmlspecialchars($cour['heure_fin']) ?></td>
            <td><a href="../edit/edit_creneau.php?id=<?= $cour['id_creneau'] ?>"><img src="../icons/modify.jpeg" width="30"></a> 
                <a href="../edit/delete_creneau.php?id=<?= $cour['id_creneau'] ?>" onclick="return confirm('Êtes-vous sûr?')"><img src="../icons/delete.png"width="30"></a>
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
            
            // Récupère tous les éléments tr du tableau
            const allRows = Array.from(table.querySelectorAll('tbody tr'));
            if (allRows.length === 0) {
                // Fallback si tbody n'existe pas
                allRows.push(...Array.from(table.querySelectorAll('tr')).slice(1));
            }

            // Stockage des données originales pour chaque ligne
            const rowsData = allRows.map(row => ({
                element: row,
                classe: row.cells[3] ? row.cells[3].textContent.trim().toLowerCase() : '',
                date: row.cells[0] ? row.cells[0].textContent.trim().toLowerCase() : '',
                code: row.cells[2] ? row.cells[2].textContent.trim().toLowerCase() : '',
                salle: row.cells[4] ? row.cells[4].textContent.trim().toLowerCase() : ''
            }));

            // Debounce pour optimiser les performances
            function debounce(fn, wait) {
                let timeout;
                return (...args) => {
                    clearTimeout(timeout);
                    timeout = setTimeout(() => fn(...args), wait);
                };
            }

            // Fonction de recherche dynamique améliorée
            function filterByClass(query) {
                const searchTerm = query.trim().toLowerCase();
                
                if (searchTerm === '') {
                    // Réinitialise l'affichage
                    rowsData.forEach(({ element }) => {
                        element.style.display = '';
                        element.classList.remove('highlight-row');
                    });
                    msg.textContent = '';
                    msg.style.color = '#718096';
                    return;
                }

                let visibleCount = 0;

                rowsData.forEach(({ element, classe, date, code, salle }) => {
                    // Cherche dans la classe en priorité, puis dans les autres colonnes
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

                // Message de résultat avec emoji pour meilleure UX
                if (visibleCount === 0) {
                    msg.textContent = `❌ Aucun résultat pour "${query}"`;
                    msg.style.color = '#f56565';
                } else if (visibleCount === 1) {
                    msg.textContent = `✓ 1 résultat trouvé`;
                    msg.style.color = '#48bb78';
                } else {
                    msg.textContent = `✓ ${visibleCount} résultats trouvés`;
                    msg.style.color = '#48bb78';
                }
            }

            // Événement input avec debounce (150ms)
            const debouncedFilter = debounce(filterByClass, 150);
            input.addEventListener('input', (e) => {
                debouncedFilter(e.target.value);
            });

            // Touche Enter applique immédiatement
            input.addEventListener('keydown', (e) => {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    filterByClass(input.value);
                }
            });

            // Touche Escape pour effacer la recherche
            input.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') {
                    input.value = '';
                    filterByClass('');
                    input.focus();
                }
            });

            // Focus initial sur le champ de recherche
            input.focus();
        });
        </script>
</body>
</html>