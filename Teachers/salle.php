<?php
include_once "con_dbb.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>salles</title>
    <link rel="stylesheet" href="style/style.css">
</head>
<body>
             <div class="Gtitre"><b>GESTION DE L'EMPLOI DU TEMPS</b></div>
      <nav>
               <h5 class="menu">MENU</h5>
                    <ul class="nav-list">
                         <li><a href="tableau.php" class="<?= (basename($_SERVER['PHP_SELF'])=='tableau.php') ? 'nav-active' : '' ?>"><img src="icons/tableau.png" alt="20" width="30">Tableau de bord</a></li>
                        <li><a href="Professeurs.php" class="<?= (basename($_SERVER['PHP_SELF'])=='Professeurs.php') ? 'nav-active' : '' ?>"><img src="icons/prof.png" alt="20" width="30">Professeurs</a></li>
                        <li><a href="salle.php" class="<?= (basename($_SERVER['PHP_SELF'])=='salle.php') ? 'nav-active' : '' ?>"><img src="icons/salle.png" alt="20" width="30"><u>Salles</u></a></li>
                        <li><a href="classe.php" class="<?= (basename($_SERVER['PHP_SELF'])=='classe.php') ? 'nav-active' : '' ?>"><img src="icons/classe.png" alt="20" width="30"> Classe</a></li>
                        <li><a href="Emploi.php" class="<?= (basename($_SERVER['PHP_SELF'])=='Emploi.php') ? 'nav-active' : '' ?>"><img src="icons/emp.png" alt="20" width="30"> Emploi du temps</a></li>
                        <li><a href="Inscription.php" class="<?= (basename($_SERVER['PHP_SELF'])=='Inscription.php') ? 'nav-active' : '' ?>"><img src="icons/inscription.jpeg" alt="20" width="30">Inscription</a></li>
                </ul>
    </nav>
    <section>
        <div class="liste">
            <h1>Liste des Salles</h1>
            <p>Listes de toutes les salles enregistres dans la base de donnees.</p>
            <form action="#" method="POST">

            </form>
        </div>
        <div class="rech">
            <h1>Rechercher les salles libres</h1>
            
            <form action="#" method="POST">
        <input type="date" name="dte" id="searchDate">
        <input type="submit" value="Rechercher" name="rech">
        <button type="button" onclick="resetSalleFilter()">Réinitialiser</button>
        <button type="button" onclick="showDebugInfo()">Voir Debug</button>
    </form>

    <div id="debug" style="display:none;"></div>
                
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.querySelector('form');
            const dateInput = document.getElementById('searchDate');
            const table = document.getElementById('mainTable');
            const debugDiv = document.getElementById('debug');
            const visibleCountSpan = document.getElementById('visibleCount');
            const totalCountSpan = document.getElementById('totalCount');

            if (!form || !dateInput || !table) {
                console.error('Éléments manquants!');
                return;
            }

            // Normalise une date en format "YYYY-MM-DD"
            function normalizeDate(str) {
                if (!str) return null;
                
                str = str.trim();
                
                // Format ISO direct (YYYY-MM-DD)
                if (/^\d{4}-\d{2}-\d{2}$/.test(str)) {
                    return str;
                }
                
                // Format français DD/MM/YYYY
                const frMatch = str.match(/^(\d{1,2})\/(\d{1,2})\/(\d{4})$/);
                if (frMatch) {
                    const day = frMatch[1].padStart(2, '0');
                    const month = frMatch[2].padStart(2, '0');
                    const year = frMatch[3];
                    return `${year}-${month}-${day}`;
                }
                
                // Format DD-MM-YYYY
                const dashMatch = str.match(/^(\d{1,2})-(\d{1,2})-(\d{4})$/);
                if (dashMatch) {
                    const day = dashMatch[1].padStart(2, '0');
                    const month = dashMatch[2].padStart(2, '0');
                    const year = dashMatch[3];
                    return `${year}-${month}-${day}`;
                }
                
                // Format avec nom de mois en français
                const monthNames = {
                    'janvier': '01', 'fevrier': '02', 'février': '02', 'mars': '03', 
                    'avril': '04', 'mai': '05', 'juin': '06', 'juillet': '07', 
                    'aout': '08', 'août': '08', 'septembre': '09', 'octobre': '10', 
                    'novembre': '11', 'decembre': '12', 'décembre': '12'
                };
                
                for (let [name, num] of Object.entries(monthNames)) {
                    const regex = new RegExp(`(\\d{1,2})\\s+${name}\\s+(\\d{4})`, 'i');
                    const match = str.match(regex);
                    if (match) {
                        const day = match[1].padStart(2, '0');
                        return `${match[2]}-${num}-${day}`;
                    }
                }
                
                // Tentative de parsing avec Date
                const d = new Date(str);
                if (!isNaN(d.getTime())) {
                    const yyyy = d.getFullYear();
                    const mm = String(d.getMonth() + 1).padStart(2, '0');
                    const dd = String(d.getDate()).padStart(2, '0');
                    return `${yyyy}-${mm}-${dd}`;
                }
                
                return null;
            }

            function filterByDate(selectedIso) {
                const tbody = table.querySelector('tbody');
                const rows = Array.from(tbody.querySelectorAll('tr'));
                
                // Retirer tous les highlights
                rows.forEach(r => r.classList.remove('highlight'));
                
                if (!selectedIso) {
                    rows.forEach(r => r.style.display = '');
                    debugDiv.innerHTML = 'Filtre réinitialisé - toutes les lignes affichées';
                    debugDiv.style.display = 'none';
                    visibleCountSpan.textContent = rows.length;
                    return;
                }
                
                let visibleCount = 0;
                let debugInfo = `<strong>🔍 Recherche pour: ${selectedIso}</strong><br><br>`;
                
                rows.forEach((row, index) => {
                    // Vérifier si c'est une ligne "Aucune salle trouvée"
                    if (row.querySelector('.no-results')) {
                        row.style.display = 'none';
                        return;
                    }
                    
                    // La colonne "Jour Occupé" est la dernière (index 4)
                    const cell = row.cells[4];
                    const text = cell ? cell.textContent.trim() : '';
                    const cellIso = normalizeDate(text);
                    
                    debugInfo += `Ligne ${index + 1}: "${text}" → normalisé: "${cellIso}" → `;
                    
                    if (cellIso === selectedIso) {
                        row.style.display = '';
                        row.classList.add('highlight');
                        visibleCount++;
                        debugInfo += '<span style="color:green;font-weight:bold;">✓ AFFICHÉE</span><br>';
                    } else {
                        row.style.display = 'none';
                        debugInfo += '<span style="color:red;">✗ CACHÉE</span><br>';
                    }
                });
                
                debugInfo += `<br><strong>📊 Résultat: ${visibleCount} ligne(s) trouvée(s)</strong>`;
                debugDiv.innerHTML = debugInfo;
                debugDiv.style.display = 'block';
                visibleCountSpan.textContent = visibleCount;
                
                // Afficher message si aucun résultat
                if (visibleCount === 0) {
                    alert(`Aucune salle n'est occupée le ${selectedIso}`);
                }
            }

            // Filtrage automatique au changement
            dateInput.addEventListener('change', function () {
                const sel = normalizeDate(this.value);
                filterByDate(sel);
            });

            // Empêcher le rechargement de la page
            form.addEventListener('submit', function (e) {
                e.preventDefault();
                const sel = normalizeDate(dateInput.value);
                filterByDate(sel);
            });

            // Fonction de réinitialisation globale
            window.resetSalleFilter = () => { 
                dateInput.value = ''; 
                filterByDate(null); 
            };
            
            window.showDebugInfo = () => {
                if (debugDiv.style.display === 'none' || !debugDiv.innerHTML) {
                    alert('Effectuez d\'abord une recherche pour voir les informations de debug.');
                } else {
                    debugDiv.style.display = debugDiv.style.display === 'none' ? 'block' : 'none';
                }
            };
        });
    </script>
              
            <?php 
        $stm=mysqli_query($con," SELECT * FROM salle");
        $salle=$stm->fetch_all(MYSQLI_ASSOC);
        ?>
        </div>
        <table id="mainTable">
            <tr>
                <th>NumSalle</th>
                <th>Capacite</th>
                <th>Type</th>
                <th>NbreCour</th>
                <th>Jour occuper</th>
                <th>Classe</th>
            </tr>
            <?php foreach($salle as $s): ?>
            <tr>
                <td><?=htmlspecialchars($s['id_salle'])?></td>
                <td><?=htmlspecialchars($s['capacite'])?></td>
                <td><?=htmlspecialchars($s['type_salle'])?></td>
                <td><?=htmlspecialchars($s['nbres de cours'])?></td>
                <td><?=htmlspecialchars($s['dte'])?></td>
                <td><?=htmlspecialchars($s['classe'])?></td>
            </tr>
            <?php endforeach;?>
        </table>
    </section>
</body>
</html>