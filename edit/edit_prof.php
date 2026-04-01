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

$id = isset($_GET['id']) ? (int)$_GET['id'] : (isset($_POST['id']) ? (int)$_POST['id'] : 0);

if ($id === 0) {
    die("ID enseignant non spécifié.");
}

$message = null;
$message_type = null;

if(isset($_POST['edit'])) {
    $nom = $_POST['nom'] ?? '';
    $prenom = $_POST['prenom'] ?? '';
    $email = $_POST['email'] ?? '';

    if(empty($nom) || empty($prenom) || empty($email)) {
        $message = "Tous les champs sont obligatoires";
        $message_type = "error";
    } else {
        try {
            $stmt = $conn->prepare("UPDATE PERSONNE SET nom=?, prenom=?, email=? WHERE id_personne=?");
            if($stmt->execute([$nom, $prenom, $email, $id])) {
                $message = "Profil enseignant modifié avec succès !";
                $message_type = "success";
            }
        } catch(PDOException $e) {
            $message = "Erreur de modification: " . $e->getMessage();
            $message_type = "error";
        }
    }
}

// Récupérer l'enseignant
$stmt_user = $conn->prepare("SELECT * FROM PERSONNE WHERE id_personne = ? AND enseignant = 1");
$stmt_user->execute([$id]);
$user = $stmt_user->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die("Enseignant introuvable.");
}

$pending = $conn->query("SELECT COUNT(*) FROM REQUETE WHERE statut='en_attente'")->fetchColumn();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier l'enseignant</title>
    <link rel="stylesheet" href="../style/style2.css">
</head>
<body>
    <div class="Gtitre"><b>GESTION DES UTILISATEURS</b></div>
    <nav>
        <button class="nav-toggle" id="navToggle" aria-label="Menu">
            <?= svg_icon('menu', 20) ?>
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
        <h1>Modifier l'enseignant</h1>
        <p style="margin-bottom: 20px; color: #666; font-size: 0.9em;">
            <?= svg_icon('info', 14) ?> Note : Pour des raisons de sécurité, le mot de passe ne peut pas être modifié par l'administrateur.
        </p>
        
        <?php if($message): ?>
            <div class="msg <?= $message_type === 'success' ? 'msg-success' : 'msg-error' ?>">
                <?= $message_type === 'success' ? svg_icon('success', 18) : svg_icon('warning', 18) ?>
                <span><?= htmlspecialchars($message) ?></span>
            </div>
        <?php endif; ?>

        <form action="" method="POST" novalidate>
            <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">
            
            <div class="row">
                <div class="form-group col-1">
                    <label>Nom</label>
                    <input type="text" name="nom" class="form-control" value="<?= htmlspecialchars($_POST['nom'] ?? $user['nom']) ?>" required>
                </div>
                <div class="form-group col-1">
                    <label>Prénom</label>
                    <input type="text" name="prenom" class="form-control" value="<?= htmlspecialchars($_POST['prenom'] ?? $user['prenom']) ?>" required>
                </div>
            </div>

            <div class="form-group">
                <label>Adresse e-mail</label>
                <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($_POST['email'] ?? $user['email']) ?>" required>
            </div>

            <div class="form-actions" style="margin-top: 24px;">
                <button type="button" class="btn-cancel" onclick="location.href='../ADMIN/Gestion.php'"><?= svg_icon('close', 16) ?> Annuler</button>
                <button type="submit" name="edit" class="btn-submit"><?= svg_icon('edit', 18) ?> Enregistrer les modifications</button>
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