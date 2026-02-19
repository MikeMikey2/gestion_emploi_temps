<?php
include_once "con_dbb.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style/style3.css">
</head>
<body>
    <div class="Gtitre"><b>GESTION DE L'EMPLOI DU TEMPS</b></div>
    <nav>
       <h5 class="menu">MENU</h5>
        <ul class="nav-list">
            <li><a href="tableau.php" class="<?= (basename($_SERVER['PHP_SELF'])=='tableau.php') ? 'nav-active' : '' ?>"><img src="icons/tableau.png" alt="20" width="30">Tableau de bord</a></li>
            <li><a href="Professeurs.php" class="<?= (basename($_SERVER['PHP_SELF'])=='Professeurs.php') ? 'nav-active' : '' ?>"><img src="icons/prof.png" alt="20" width="30"><u>Professeurs</u></a></li>
            <li><a href="salle.php" class="<?= (basename($_SERVER['PHP_SELF'])=='salle.php') ? 'nav-active' : '' ?>"><img src="icons/salle.png" alt="20" width="30"> Salles</a></li>
            <li><a href="classe.php" class="<?= (basename($_SERVER['PHP_SELF'])=='classe.php') ? 'nav-active' : '' ?>"><img src="icons/classe.png" alt="20" width="30"> Classe</a></li>
            <li><a href="Emploi.php" class="<?= (basename($_SERVER['PHP_SELF'])=='Emploi.php') ? 'nav-active' : '' ?>"><img src="icons/emp.png" alt="20" width="30"> Emploi du temps</a></li>
            <li><a href="Inscription.php" class="<?= (basename($_SERVER['PHP_SELF'])=='Inscription.php') ? 'nav-active' : '' ?>"><img src="icons/inscription.jpeg" alt="20" width="30">Inscription</a></li>
        </ul>
    </nav>
    <section>
        <div class="liste">
            <h1>Liste des professeurs</h1>
        <p>liste de tous les professeurs enregistres dans la base de donnees.</p>
        <form action="edit/add_prof.php" method="POST">
            <input type="submit" value="Ajouter" ">
        </form>
        <?php 
        $stm=mysqli_query($con," SELECT * FROM professeur");
        $prof=$stm->fetch_all(MYSQLI_ASSOC);
        ?>
        </div>
        <div class="rech">
            <input type="text" class="search" placeholder="Entrer le nom d'un professeur">
                        <script>
                function initSearch() {
                    const input = document.querySelector('.search');
                    const table = document.querySelector('table');
                    
                    if (!input || !table) return;

                    function getRows() {
                        // récupère les lignes à chaque fois (détecte les nouvelles)
                        return Array.from(table.querySelectorAll('tr')).slice(1);
                    }

                    function debounce(fn, wait) {
                        let t;
                        return (...args) => {
                            clearTimeout(t);
                            t = setTimeout(() => fn(...args), wait);
                        };
                    }

                    function filter(q) {
                        const query = q.trim().toLowerCase();
                        const rows = getRows(); // récupère les lignes actuelles
                        
                        if (query === '') {
                            rows.forEach(r => r.style.display = '');
                            return;
                        }
                        
                        let visible = 0;
                        rows.forEach(row => {
                            const cell = row.cells[1]; // colonne "Nom" (index 1)
                            const nom = cell ? cell.textContent.trim().toLowerCase() : '';
                            const show = nom.includes(query);
                            row.style.display = show ? '' : 'none';
                            if (show) visible++;
                        });
                    }

                    const debouncedFilter = debounce(filter, 200);
                    input.addEventListener('input', (e) => debouncedFilter(e.target.value));

                    input.addEventListener('keydown', function (e) {
                        if (e.key === 'Enter') {
                            e.preventDefault();
                            filter(this.value);
                        }
                    });
                }

                // initialise au chargement
                document.addEventListener('DOMContentLoaded', initSearch);
                
                // réinitialise après ajout dynamique (si besoin)
                window.reinitSearch = initSearch;
            </script>
        </div>
    </section>
    <table>
        
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Prenom</th>
            <th>Matiere</th>
            <th>Grade</th>
            <th>Action</th>
        </tr>
        <?php
        foreach($prof as $p):
        ?>
        <tr>
            <td><?=htmlspecialchars($p['id_prof'])?></td>
            <td><?=htmlspecialchars($p['nom_prof'])?></td>
            <td><?=htmlspecialchars($p['prenom'])?></td>
            <td><?=htmlspecialchars($p['nom_matiere'])?></td>
            <td><?=htmlspecialchars($p['Grade'])?></td>
            <td><a href="edit_prof.php?id=<?= $p['id'] ?>">Modifier</a> 
            | 
            <a href="delete_prof.php?id=<?= $p['id'] ?>" onclick="return confirm('Êtes-vous sûr?')"><img src="icons/delete.png" alt="50" width="30"></a></td>
        </tr>
        <?php 
        endforeach;
        ?>
    </table>
</body>
</html>