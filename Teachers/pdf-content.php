<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'etudiant') {
    header("Location: ../index.php");
    exit;
}
$id = (int)$_SESSION['id_personne'];
include_once "../ADMIN/con_dbb.php";

// Récupérer la filière de l'étudiant connecté
$stmt_etudiant = $con->prepare("SELECT filiere FROM PERSONNE WHERE id_personne = ? ");
$stmt_etudiant->bind_param("i", $id);
$stmt_etudiant->execute();
$etudiant = $stmt_etudiant->get_result()->fetch_assoc();

if (!$etudiant || !$etudiant['filiere']) {
    die("Filière introuvable pour cet étudiant.");
}

$filiere = $etudiant['filiere'];

$id_lecon = isset($_POST['id_lecon']) ? (int)$_POST['id_lecon'] : 0;

if ($id_lecon === 0) {
    die("Aucune leçon spécifiée.");
}

// Récupérer la leçon exacte
$stmt = $con->prepare("SELECT l.*, c.code_cours FROM LEÇON l LEFT JOIN COURS c ON l.id_cours = c.id_cours WHERE l.id_leçon = ? AND l.filiere = ?");
$stmt->bind_param("is", $id_lecon, $filiere);
$stmt->execute();
$res = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leçon - PDF</title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; padding: 20px; color: #333; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #2563eb; padding-bottom: 15px; }
        .header h1 { color: #1e40af; font-size: 24px; margin: 0 0 10px 0; }
        .meta { font-size: 14px; color: #555; margin-bottom: 5px; }
        .content { margin-top: 30px; font-size: 15px; line-height: 1.6; white-space: pre-wrap; }
    </style>
</head>
<body>
<?php if ($res->num_rows === 0): ?>
    <p>Leçon introuvable ou vous n'y avez pas accès.</p>
<?php else: ?>
    <?php while($row = $res->fetch_assoc()): ?>
        <div class="header">
            <h1><?= htmlspecialchars($row['titre']) ?></h1>
            <div class="meta"><strong>Cours :</strong> <?= htmlspecialchars($row['code_cours']) ?></div>
            <div class="meta"><strong>Filière :</strong> <?= htmlspecialchars($row['filiere']) ?></div>
        </div>
        <div class="content">
<?= htmlspecialchars($row['corps']) ?>
        </div>
    <?php endwhile; ?>
<?php endif; ?>
</section>
</body>
</html>