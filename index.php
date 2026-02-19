<?php
session_start();

if(isset($_POST['acces'])){
    include_once "ADMIN/con_dbb.php";
    
    if(isset($_POST['email']) && isset($_POST['mdp'])){
        $email = $_POST['email'];
        $mdp = $_POST['mdp'];
        
        // Vérification dans la table ADMIN
        $stmt = $con->prepare("SELECT * FROM ADMIN WHERE email=? AND mot_de_passe=?");
        $stmt->bind_param("ss", $email, $mdp);
        $stmt->execute();
        $req = $stmt->get_result();

        if($req && $req->num_rows >= 1){
            $_SESSION['email'] = $email;
            $_SESSION['role'] = 'admin';
            header("Location: ADMIN/tableau.php");
            exit();
        }

        // Si pas admin, vérifier si c'est un etudiant dans PERSONNE
        $stmt2 = $con->prepare("SELECT * FROM PERSONNE WHERE email=? AND mot_de_passe=? AND enseignant=0");
        $stmt2->bind_param("ss", $email, $mdp);
        $stmt2->execute();
        $res2 = $stmt2->get_result();

        if($res2 && $res2->num_rows >= 1){
            $_SESSION['email'] = $email;
            $_SESSION['role'] = 'enseignant';
            header("Location: Students/tableau.php");
            exit();
        }else{
            $erreur = "Email ou mot de passe incorrect !";
        }
        // si pas admin,verifier si c'est un enseignant dans PERSONNE
        $stmt2 = $con->prepare("SELECT * FROM PERSONNE WHERE email=? AND mot_de_passe=? AND enseignant=1");
        $stmt2->bind_param("ss", $email, $mdp);
        $stmt2->execute();
        $res2 = $stmt2->get_result();

        if($res2 && $res2->num_rows >= 1){
            $_SESSION['email'] = $email;
            $_SESSION['role'] = 'enseignant';
            header("Location: Teachers/tableau.php");
            exit();
        }else{
            $erreur = "Email ou mot de passe incorrect !";
        } 
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="style/connexion.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div id="myconnect">
       <h1>CONNEXION</h1>
         <?php 
        if(isset($erreur)){
            echo"<p class='Erreur'>".$erreur."</p>";
        }
        ?>
       <form action="#" method="POST">
        <input type="text" name="email" placeholder="Entrer votre email">
        <div class="password-field">
                    <input 
                        type="password" 
                        id="passwordInput"
                        name="mdp" 
                        placeholder="Entrer le mot de passe" 
                        required >
                    <button type="button" class="toggle-password" onclick="togglePassword()">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
        <input type="submit" value="Acceder" name="acces" >
       </form>
    </div>
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
    </script>
</body>
</html>