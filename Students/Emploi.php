<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appli</title>
    <link rel="stylesheet" href="../style/style2.css">
</head>
<body>
    <div ><b>GESTION DE L'EMPLOI DU TEMPS</b></div>
      <nav>
     <h5 class="menu">MENU</h5>
         <ul class="nav-list">
            <li><a href="tableau.php" class="<?= (basename($_SERVER['PHP_SELF'])=='tableau.php') ? 'nav-active' : '' ?>"><img src="icons/tableau.png" alt="20" width="30">Tableau de bord</a></li>
            <li><a href="Professeurs.php" class="<?= (basename($_SERVER['PHP_SELF'])=='Professeurs.php') ? 'nav-active' : '' ?>"><img src="icons/prof.png" alt="20" width="30">Professeurs</a></li>
            <li><a href="salle.php" class="<?= (basename($_SERVER['PHP_SELF'])=='salle.php') ? 'nav-active' : '' ?>"><img src="icons/salle.png" alt="20" width="30"> Salles</a></li>
            <li><a href="classe.php" class="<?= (basename($_SERVER['PHP_SELF'])=='classe.php') ? 'nav-active' : '' ?>"><img src="icons/classe.png" alt="20" width="30"> Classe</a></li>
            <li><a href="Emploi.php" class="<?= (basename($_SERVER['PHP_SELF'])=='Emploi.php') ? 'nav-active' : '' ?>"><img src="icons/emp.png" alt="20" width="30"> <u>Emploi du temps</u></a></li>
            <li><a href="Inscription.php" class="<?= (basename($_SERVER['PHP_SELF'])=='Inscription.php') ? 'nav-active' : '' ?>"><img src="icons/inscription.jpeg" alt="20" width="30">Inscription</a></li>
        </ul>
    </nav>
    <section>
        <h1>Liste d'emploi du temps</h1>
        <div class="choix">
            <p>Voici notre emploi du temps !</p>
            <form action="#" method="POST">
                <input type="submit" value="Ajouter" name="ajout">
                <input type="submit" value="Emplois" name="emp">
            </form>
        </div>
    </section>
    <div class="recherche">
        <input type="text" id="search" placeholder="Entrer une classe">
        <small id="searchMessage" aria-live="polite" style="margin-left:10px;"></small>

        <script>
        document.addEventListener('DOMContentLoaded', function () {
            const input = document.getElementById('search');
            const msg = document.getElementById('searchMessage');
            const table = document.querySelector('table');
            if (!table) return;
            const rows = Array.from(table.querySelectorAll('tr')).slice(1); // exclut l'en-tête

            // debounce simple
            function debounce(fn, wait) {
                let t;
                return (...args) => {
                    clearTimeout(t);
                    t = setTimeout(() => fn(...args), wait);
                };
            }

            function filter(q) {
                const query = q.trim().toLowerCase();
                if (query === '') {
                    rows.forEach(r => r.style.display = '');
                    msg.textContent = '';
                    return;
                }
                let visible = 0;
                rows.forEach(row => {
                    const cell = row.cells[5]; // colonne "Niveau" (index 5)
                    const cls = cell ? cell.textContent.trim().toLowerCase() : '';
                    const show = cls.includes(query);
                    row.style.display = show ? '' : 'none';
                    if (show) visible++;
                });
                msg.textContent = visible ? visible + ' résultat(s) trouvé(s).' : 'Aucun emploi du temps pour cette classe.';
            }

            const debouncedFilter = debounce(filter, 200); // déclenche 200ms après la saisie
            input.addEventListener('input', (e) => debouncedFilter(e.target.value));

            // touche Enter applique immédiatement
            input.addEventListener('keydown', function (e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    filter(this.value);
                }
            });
        });
        </script>
    </div>
        <?php
        //connecter a la base de donnees
        include_once "con_dbb.php";
        $stm=mysqli_query($con," SELECT * FROM COURS");
        $cours=$stm->fetch_all(MYSQLI_ASSOC);
        ?>
      <table>
            <tr>
            <th>Jour</th>
            <th>Matiere</th>
            <th>Numsalle</th>
            <th>Professeur</th>
            <th>Niveau</th>
            <th>Action</th>
        </tr>  
        <?php foreach($cours as $cour): ?>
         <tr>
            <td><?=htmlspecialchars($cour['date_creation']) ?></td>
            <td ><?=htmlspecialchars($cour['code_cours']) ?></td>
            <td ><?=htmlspecialchars($cour['id_salle']) ?></td>
            <td ><?=htmlspecialchars($cour['nom_prof']) ?></td>
            <td><?=htmlspecialchars($cour['nom_classe']) ?></td>
            <td></td>
        </tr>   
        <?php endforeach; ?>
</body>
</html>