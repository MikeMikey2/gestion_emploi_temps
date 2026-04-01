<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit;
}

try {
    $conn = new PDO("mysql:host=localhost;dbname=emploi", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Erreur de connexion: " . $e->getMessage());
}

include_once "../icons/icons.php";

$id_admin_session = $_SESSION['id_personne'];
$message = null;
$message_type = null;

if(isset($_POST['add'])) {
    $date = $_POST['date'] ?? '';
    $heure_debut = $_POST['heure_debut'] ?? '';
    $heure_fin = $_POST['heure_fin'] ?? '';
    $salle = $_POST['salle'] ?? '';
    $id_cours = $_POST['id_cours'] ?? '';
    $filiere = $_POST['filiere'] ?? '';
    $id_personne = $_POST['id_personne'] ?? '';
    
    if(empty($date) || empty($heure_debut) || empty($heure_fin) || empty($salle) || empty($id_cours) || empty($filiere) || empty($id_personne)) {
        $message = "Tous les champs sont obligatoires";
        $message_type = "error";
    } else {
        try {
            $stmt = $conn->prepare("INSERT INTO CRENEAU(date, heure_debut, heure_fin, salle, id_cours, id_admin, filiere, id_personne) VALUES(?, ?, ?, ?, ?, ?, ?, ?)");
            if($stmt->execute([$date, $heure_debut, $heure_fin, $salle, $id_cours, $id_admin_session, $filiere, $id_personne])) {
                $message = "Créneau ajouté avec succès !";
                $message_type = "success";
                $date = $heure_debut = $heure_fin = $salle = $id_cours = $filiere = $id_personne = '';
            }
        } catch(PDOException $e) {
            $message = "Erreur BDD: " . $e->getMessage();
            $message_type = "error";
        }
    }
}

// Fetching dynamic Lists
$cours_list = $conn->query("SELECT id_cours, code_cours, description FROM COURS")->fetchAll(PDO::FETCH_ASSOC);
$profs_list = $conn->query("SELECT id_personne, nom, prenom FROM PERSONNE WHERE enseignant = 1 ORDER BY nom")->fetchAll(PDO::FETCH_ASSOC);
$salles_list = $conn->query("SELECT DISTINCT nom_salle FROM SALLE ORDER BY nom_salle")->fetchAll(PDO::FETCH_ASSOC);

$pending = $conn->query("SELECT COUNT(*) FROM REQUETE WHERE statut='en_attente'")->fetchColumn();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un créneau</title>
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
            <li><a href="../ADMIN/tableau.php" class="<?= (basename($_SERVER['PHP_SELF'])=='tableau.php') ? 'nav-active' : '' ?>"><?= svg_icon('dashboard', 20) ?>Tableau de bord</a></li>
            <li><a href="../ADMIN/Gestion.php" class="<?= (basename($_SERVER['PHP_SELF'])=='Gestion.php') ? 'nav-active' : '' ?>"><?= svg_icon('gestion', 20) ?>Gestion</a></li>
            <li><a href="../ADMIN/Emploi.php" class="<?= (basename($_SERVER['PHP_SELF'])=='Emploi.php') ? 'nav-active' : '' ?>"><?= svg_icon('emploi', 20) ?> Emploi du temps</a></li>
            <li><a href="../ADMIN/Requetes.php" class="<?= (basename($_SERVER['PHP_SELF'])=='Requetes.php') ? 'nav-active' : '' ?>"><?= svg_icon('requetes', 20) ?>Requêtes<span class="badge"><?= $pending ?></span></a></li>
        </ul>
        <ul class="nav-footer" id="navFooter">
            <li><a href="../logout.php"><?= svg_icon('logout', 20) ?>Déconnexion</a></li>
        </ul>
    </nav>
    <section class="form-container">
        <h1>Ajouter un créneau</h1>
        <?php if($message): ?>
            <div class="msg <?= $message_type === 'success' ? 'msg-success' : 'msg-error' ?>">
                <?= $message_type === 'success' ? svg_icon('success', 18) : svg_icon('warning', 18) ?>
                <span><?= htmlspecialchars($message) ?></span>
            </div>
        <?php endif; ?>
        <form action="" method="POST" novalidate>
            <div class="row">
                <div class="form-group col-2">
                    <label>Date</label>
                    <input type="date" name="date" class="form-control" value="<?= htmlspecialchars($date ?? '') ?>" required>
                </div>
                <div class="form-group col-1">
                    <label>Salle</label>
                    <select name="salle" class="form-control" required>
                        <option value="">-- Sélectionnez une salle --</option>
                        <?php foreach($salles_list as $sl): ?>
                            <option value="<?= htmlspecialchars($sl['nom_salle']) ?>" <?= (isset($salle) && $salle == $sl['nom_salle']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($sl['nom_salle']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-1">
                    <label>Heure de début</label>
                    <input type="time" name="heure_debut" class="form-control" value="<?= htmlspecialchars($heure_debut ?? '') ?>" required>
                </div>
                <div class="form-group col-1">
                    <label>Heure de fin</label>
                    <input type="time" name="heure_fin" class="form-control" value="<?= htmlspecialchars($heure_fin ?? '') ?>" required>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-1">
                    <label>Cours</label>
                    <select name="id_cours" class="form-control" required>
                        <option value="">-- Sélectionnez un cours --</option>
                        <?php foreach($cours_list as $cours): ?>
                            <option value="<?= htmlspecialchars($cours['id_cours']) ?>" <?= (isset($id_cours) && $id_cours == $cours['id_cours']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($cours['code_cours']) ?> - <?= htmlspecialchars(strlen($cours['description']) > 30 ? substr($cours['description'],0,30).'...' : $cours['description']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group col-1">
                    <label>Filière</label>
                    <select name="filiere" class="form-control" required>
                        <option value="">-- Sélectionnez une filière --</option>
                        <option value="IGL1" <?= (isset($filiere) && $filiere == 'IGL1') ? 'selected' : '' ?>>IGL1</option>
                        <option value="IGL2" <?= (isset($filiere) && $filiere == 'IGL2') ? 'selected' : '' ?>>IGL2</option>
                        <option value="FCL1" <?= (isset($filiere) && $filiere == 'FCL1') ? 'selected' : '' ?>>FCL1</option>
                        <option value="FCL2" <?= (isset($filiere) && $filiere == 'FCL2') ? 'selected' : '' ?>>FCL2</option>
                        <option value="RES1" <?= (isset($filiere) && $filiere == 'RES1') ? 'selected' : '' ?>>RES1</option>
                        <option value="RES2" <?= (isset($filiere) && $filiere == 'RES2') ? 'selected' : '' ?>>RES2</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label>Enseignant attribué</label>
                <select name="id_personne" class="form-control" required>
                    <option value="">-- Sélectionnez un enseignant --</option>
                    <?php foreach($profs_list as $prof): ?>
                        <option value="<?= htmlspecialchars($prof['id_personne']) ?>" <?= (isset($id_personne) && $id_personne == $prof['id_personne']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars(strtoupper($prof['nom']) . ' ' . ucfirst($prof['prenom'])) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-actions" style="margin-top: 24px;">
                <button type="button" class="btn-cancel" onclick="location.href='../ADMIN/Emploi.php'"><?= svg_icon('close', 16) ?> Annuler</button>
                <button type="submit" name="add" class="btn-submit"><?= svg_icon('add', 18) ?> Ajouter le créneau</button>
            </div>
        </form>
    </section>

    <script>
    const navToggle = document.getElementById('navToggle');
    const navList   = document.getElementById('navList');
    const navFooter = document.getElementById('navFooter');

    if(navToggle) {
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
    }
    </script>
</body>
</html>