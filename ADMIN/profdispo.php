<?php
include_once "../ADMIN/con_dbb.php";
// verification des enseignants qui n'ont sont disponibles
session_start();


$stmt = $con->prepare("SELECT d.*,p.nom,p.prenom FROM DISPONIBILITE d JOIN PERSONNE p ON d.id_personne = p.id_personne WHERE p.enseignant = 1  ORDER BY d.date, d.heure");
$stmt->bind_param("i", $_SESSION['id_personne']);
$stmt->execute();
$result = $stmt->get_result();
foreach($result as $row) {

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <section>
        <h1>Disponibilité</h1>
        <p><strong>Nom:</strong> <?= htmlspecialchars($row['nom'] ?? '') ?></p>
        <p><strong>Prénom:</strong> <?= htmlspecialchars($row['prenom'] ?? '') ?></p>   
        <p><strong>Date:</strong> <?= htmlspecialchars($row['date'] ?? '') ?></p>
        <p><strong>Heure dispo:</strong> <?= htmlspecialchars($row['heure']) ?? '' ?></p>
    </section>
    <?php
}
$stmt->close();
?>
</body>
</html>