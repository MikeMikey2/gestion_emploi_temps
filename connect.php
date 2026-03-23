<?php
session_start();
if(isset($_POST['acces'])){
    include_once "ADMIN/con_dbb.php";
    if(isset($_POST['email']) && isset($_POST['mdp'])){
        $email = $_POST['email'];
        $mdp = $_POST['mdp'];

        // Vérification ADMIN (mot de passe en clair car table ADMIN)
        $stmt = $con->prepare("SELECT * FROM ADMIN WHERE email=?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $req = $stmt->get_result();
        if($req && $req->num_rows >= 1){
            $admin = $req->fetch_assoc();
            if($admin['mot_de_passe'] === $mdp){ // Admin en clair (ou adapter si hashé)
                $_SESSION['email'] = $email;
                $_SESSION['role'] = 'admin';
                $_SESSION['id_personne'] = $admin['id_admin'];
                header("Location: ADMIN/tableau.php");
                exit();
            }
        }

        // Vérification ÉTUDIANT ou ENSEIGNANT dans PERSONNE
        $stmt2 = $con->prepare("SELECT * FROM PERSONNE WHERE email=?");
        $stmt2->bind_param("s", $email);
        $stmt2->execute();
        $res2 = $stmt2->get_result();

        if($res2 && $res2->num_rows >= 1){
            $row = $res2->fetch_assoc();

            //  Vérification du mot de passe hashé
            if(password_verify($mdp, $row['mot_de_passe'])){

                $_SESSION['email'] = $email;
                $_SESSION['id_personne'] = $row['id_personne'];

                if($row['enseignant'] == 0){
                    // C'est un étudiant
                    $_SESSION['role'] = 'etudiant';
                    $_SESSION['filiere'] = $row['filiere'];
                    header("Location: Students/Emploi.php");
                    exit();
                } else {
                    // C'est un enseignant
                    $_SESSION['role'] = 'enseignant';
                    header("Location: Teachers/Emploi.php");
                    exit();
                }

            } else {
                $erreur = "Email ou mot de passe incorrect !";
            }

        } else {
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