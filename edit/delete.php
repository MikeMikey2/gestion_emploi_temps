<?php
$id = $_GET['id'];
echo "ID à supprimer : " . htmlspecialchars($id);
include_once "../ADMIN/con_dbb.php";
$sql="DELETE FROM PERSONNE WHERE id_personne = $id";
$result=mysqli_query($con,$sql);
if($result){
    header("Location: ../ADMIN/Gestion.php?delete=success");
}else{
    header("Location: ../ADMIN/Gestion.php?delete=error");
}
?>`