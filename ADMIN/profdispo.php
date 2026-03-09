<?php
include_once "../ADMIN/con_dbb.php";
// verification des enseignants qui n'ont sont disponibles
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'enseignant') {
    header("Location: ../index.php");
    exit;
}

$stmt = $con->prepare("SELECT disponibilite FROM PERSONNE WHERE  enseignant = 1");
$stmt->execute();
$result = $stmt->get_result();
foreach($result as $row) {
    $disponibilite = $row['disponibilite'];
    // Traitez la disponibilité comme nécessaire
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
</body>
</html>