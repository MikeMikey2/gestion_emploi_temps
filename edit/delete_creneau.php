<?php
$id = $_GET['id'];
echo "ID à supprimer : " . htmlspecialchars($id);
include_once "../ADMIN/con_dbb.php";
$sql="DELETE FROM CRENEAU WHERE id_creneau = $id";
$result=mysqli_query($con,$sql);
if($result){
    header("Location: ../ADMIN/Emploi.php?delete=success");
}else{
    header("Location: ../ADMIN/Emploi.php?delete=error");
}
?>`