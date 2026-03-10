<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'etudiant') {
    header("Location: ../index.php");
    exit;
}

include_once "../ADMIN/con_dbb.php";

$id = (int)$_SESSION['id_personne'];

// Récupérer la filière de l'étudiant connecté
$stmt_etudiant = $con->prepare("SELECT filiere FROM PERSONNE WHERE id_personne = ?");
$stmt_etudiant->bind_param("i", $id);
$stmt_etudiant->execute();
$etudiant = $stmt_etudiant->get_result()->fetch_assoc();

if (!$etudiant || !$etudiant['filiere']) {
    die("Filière introuvable pour cet étudiant.");
}

$filiere = $etudiant['filiere'];

// Récupérer les leçons de la filière de l'étudiant (créées par des enseignants)
$stmt = $con->prepare("SELECT l.* FROM LEÇON l JOIN PERSONNE p ON l.id_personne = p.id_personne WHERE l.filiere = ? AND p.enseignant = 1 ORDER BY l.id_leçon DESC LIMIT 1");
$stmt->bind_param("s", $filiere);
$stmt->execute();
$res = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Leçons</title>
    <link rel="stylesheet" href="../style/style2.css">
</head>
<body>
<div class="Gtitre"><b>COURS</b></div>
<section>
<?php if ($res->num_rows === 0): ?>
    <p>Aucune leçon disponible pour votre filière.</p>
<?php else: ?>
    <?php while($row = $res->fetch_assoc()): ?>
        <div class="pdf-content">
            <h2>Leçon <?= htmlspecialchars($row['id_leçon']) ?> : <?= htmlspecialchars($row['titre']) ?></h2>
            <p><strong>Code du cours :</strong> <?= htmlspecialchars($row['id_cours']) ?></p>
            <p><strong>Filière :</strong> <?= htmlspecialchars($row['filiere']) ?></p>
            <hr>
            <div class="lesson-body">
                <?= htmlspecialchars($row['corps']) ?>
            </div>
        </div>
    <?php endwhile; ?>
<?php endif; ?>
</section>
</body>
</html>