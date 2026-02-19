<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
include_once "../ADMIN/con_dbb.php";
$id = isset($_GET['id']) ? $_GET['id'] : (isset($_POST['id']) ? $_POST['id'] : null);
if(isset($_POST['nom']) &&
 isset($_POST['prenom']) && 
 isset($_POST['email']) &&
  isset($_POST['mot_de_passe'])&&
  $_POST['nom'] != '' &&    
  $_POST['prenom'] != '' &&
  $_POST['email'] != '' &&
  $_POST['mot_de_passe'] != ''){
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $email  = $_POST['email'];
        $mot_de_passe = $_POST['mot_de_passe'];
    $stmt = $con->prepare("UPDATE PERSONNE SET nom=?, prenom=?, email=?, mot_de_passe=? WHERE id_personne=?");
$stmt->bind_param("ssssi", $nom, $prenom, $email, $mot_de_passe, $id);

    if($stmt->execute()){
        header("Location: ../ADMIN/Gestion.php?update=success");
        exit();
    }else{
        header("Location: ../ADMIN/Gestion.php?update=error");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter</title>
    <link rel="stylesheet" href="../style/style2.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="Gtitre"><b>GESTION DE L'EMPLOI DU TEMPS</b></div>
    <nav>
       <h5 class="menu">MENU</h5>
        <ul class="nav-list">
            <li><a href="../ADMIN/tableau.php" class="<?= (basename($_SERVER['PHP_SELF'])=='tableau.php') ? 'nav-active' : '' ?>"><img src="../icons/table.png" alt="20" width="30">Tableau de bord</a></li>
            <li><a href="../ADMIN/Gestion.php" class="<?= (basename($_SERVER['PHP_SELF'])=='Gestion.php') ? 'nav-active' : '' ?>"><img src="../icons/per.png" alt="20" width="30">Gestion</a></li>
            <li><a href="../ADMIN/Emploi.php" class="<?= (basename($_SERVER['PHP_SELF'])=='Emploi.php') ? 'nav-active' : '' ?>"><img src="../icons/evenement.png" alt="20" width="30"> Emploi du temps</a></li>
            <li><a href="../ADMIN/Requetes.php" class="<?= (basename($_SERVER['PHP_SELF'])=='Requetes.php') ? 'nav-active' : '' ?>"><img src="../icons/message.jpeg" alt="20" width="30">Requetes<span class="badge"><?php echo mysqli_num_rows(mysqli_query($con, "SELECT * FROM REQUETE WHERE statut='en_attente'")); ?></span></a></li>
        </ul>
    </nav>
    <section>
            <h1>Modifier les donnees de personne</h1>

            <?php
           
            $stmt2 = $con->prepare("SELECT * FROM PERSONNE WHERE id_personne = ?");
            $stmt2->bind_param("i", $id);
            $stmt2->execute();
            $result = $stmt2->get_result();
        
            while($personne = mysqli_fetch_assoc($result)){
            ?>
                <form action="#" method="POST" >
                <input type="hidden" name="id" value="<?=($personne['id_personne']) ?>">

                <input 
                    type="text" 
                    name="nom" 
                    placeholder="Nom actuel: <?= ($personne['nom']) ?>">
                
                <input 
                    type="text" 
                    name="prenom" 
                    placeholder="Prénom actuel: <?= ($personne['prenom']) ?>">
                
                <input 
                    type="email" 
                    name="email" 
                    placeholder="Email actuel: <?= ($personne['email']) ?>">
                
                <div class="password-field">
                    <input 
                        type="password" 
                        id="passwordInput"
                        name="mot_de_passe" 
                        placeholder="Nouveau mot de passe (laisser vide = conserver):<?=($personne['mot_de_passe'])?>">
                    <button type="button" class="toggle-password" onclick="togglePassword()">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
                
                <input 
                    type="submit" 
                    value="Modifier" 
                    name="add">
            </form>
            <?php } ?>
    </section>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('passwordInput');
            const toggleBtn = document.querySelector('.toggle-password i');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleBtn.classList.remove('fa-eye');
                toggleBtn.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleBtn.classList.remove('fa-eye-slash');
                toggleBtn.classList.add('fa-eye');
            }
        }

        // Fermeture et auto-dismiss des messages
        document.addEventListener('DOMContentLoaded', function(){
            const msg = document.querySelector('.msg');
            if(!msg) return;
            const close = msg.querySelector('.msg-close');
            const hide = () => { msg.style.transition = 'opacity 0.3s ease'; msg.style.opacity = '0'; setTimeout(()=>msg.remove(),350); };
            close && close.addEventListener('click', hide);
            setTimeout(hide, 5000);
        });
    </script>
</body>
</html>