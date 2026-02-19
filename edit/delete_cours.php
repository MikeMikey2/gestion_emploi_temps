<?php
$id=$_POST['id_cours'];
include_once "../ADMIN/con_dbb.php";
$sql="DELETE FROM COURS WHERE id_cours = $id";
$result=mysqli_query($con,$sql);
if($result){
    header("Location: ../ADMIN/Gestion.php?delete=success");
}else{
    header("Location: ../ADMIN/Gestion.php?delete=error");
}
?>