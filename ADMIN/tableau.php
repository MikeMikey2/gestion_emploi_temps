<?php
session_start();
include_once "con_dbb.php";
include_once "../icons/icons.php";
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord</title>
    <link rel="stylesheet" href="../style/style2.css">
</head>
<body>
    <div class="Gtitre"><b>AFFICHAGE DU TABLEAU DE BORD</b></div>
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
        <div class="choix">
            <p>Tableau de bord</p>
            <div class="container">
                <div class="nbprof">
                    <h2>Utilisateurs</h2>
                    <h4><span><?php
                        $result = $con->query("SELECT COUNT(*) AS n FROM PERSONNE");
                        echo $result ? $result->fetch_assoc()['n'] : '0';
                    ?></span></h4>
                </div>
                <div class="nbclass">
                    <h2>Cours actifs</h2>
                    <h4><span><?php
                        $result = $con->query("SELECT COUNT(*) AS n FROM COURS");
                        echo $result ? $result->fetch_assoc()['n'] : '0';
                    ?></span></h4>
                </div>
                <div class="nbsalles">
                    <h2>Créneaux cette semaine</h2>
                    <h4><span><?php
                        $result = $con->query("SELECT COUNT(*) AS n FROM CRENEAU");
                        echo $result ? $result->fetch_assoc()['n'] : '0';
                    ?></span></h4>
                </div>
            </div>

            <div class="new">
                <div class="creneau">
                    <h2>Dernier cours ajouté</h2>
                    <p>Voici le dernier créneau ajouté à la base de données.</p>
                    <ul>
                        <?php
                        $result = $con->query("SELECT c.*, co.code_cours FROM CRENEAU c JOIN COURS co ON c.id_cours = co.id_cours ORDER BY c.id_creneau DESC LIMIT 1");
                        if ($result && $result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<li>"
                                    . htmlspecialchars($row['nom_creneau'])
                                    . " — " . htmlspecialchars($row['heure_debut'])
                                    . " → " . htmlspecialchars($row['heure_fin'])
                                    . " | " . htmlspecialchars($row['date'])
                                    . " | Salle " . htmlspecialchars($row['salle'])
                                    . " | " . htmlspecialchars($row['filiere'])
                                    . " | " . htmlspecialchars($row['code_cours'])
                                    . "</li>";
                            }
                        } else {
                            echo "<li>Aucun créneau ajouté récemment.</li>";
                        }
                        ?>
                    </ul>
                </div>

                <div class="requete">
                    <h2>Dernières requêtes ajoutées</h2>
                    <p>Voici la dernière requête ajoutée à la base de données.</p>
                    <ul>
                        <?php
                        $result = $con->query("SELECT * FROM REQUETE WHERE statut = 'en_attente' ORDER BY id_requete DESC LIMIT 1");
                        if ($result && $result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<li>"
                                    . htmlspecialchars($row['statut'])
                                    . " — " . htmlspecialchars($row['objet'])
                                    . " — " . htmlspecialchars($row['message'])
                                    . " — " . htmlspecialchars($row['date_envoi'])
                                    . "</li>";
                            }
                        } else {
                            echo "<li>Aucune requête ajoutée récemment.</li>";
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <script>
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