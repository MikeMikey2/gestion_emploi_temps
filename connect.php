<?php
session_start();

// Redirection si déjà connecté
if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] === 'admin') { header("Location: ADMIN/tableau.php"); exit(); }
    if ($_SESSION['role'] === 'enseignant') { header("Location: Teachers/Emploi.php"); exit(); }
    if ($_SESSION['role'] === 'etudiant') { header("Location: Students/Emploi.php"); exit(); }
}

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
            if($admin['mot_de_passe'] === $mdp){
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

            if(password_verify($mdp, $row['mot_de_passe'])){
                $_SESSION['email'] = $email;
                $_SESSION['id_personne'] = $row['id_personne'];

                if($row['enseignant'] == 0){
                    $_SESSION['role'] = 'etudiant';
                    $_SESSION['filiere'] = $row['filiere'];
                    header("Location: Students/Emploi.php");
                    exit();
                } else {
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
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="style/connexion.css">
</head>
<body>
    <div class="auth-wrapper">
        <!-- Nom de l'application -->
        <div class="app-brand">
            <div class="brand-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            </div>
            <h2>EduGest</h2>
            <p>Gestion de l'emploi du temps</p>
        </div>

        <div id="myconnect">
           <h1>
               <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
               CONNEXION
           </h1>
           <?php 
        if(isset($erreur)){
            echo "<p class='Erreur'>
                    <svg xmlns='http://www.w3.org/2000/svg' width='18' height='18' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'><circle cx='12' cy='12' r='10'/><line x1='12' y1='8' x2='12' y2='12'/><line x1='12' y1='16' x2='12.01' y2='16'/></svg>
                    ".$erreur."
                  </p>";
        }
        ?>
       <form action="#" method="POST">
            <div class="input-wrapper">
                <input type="text" name="email" placeholder="Entrer votre email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" autocomplete="email">
                <span class="input-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                </span>
            </div>
            <div class="password-field">
                <input 
                    type="password" 
                    id="passwordInput"
                    name="mdp" 
                    placeholder="Entrer le mot de passe" 
                    required>
                <button type="button" class="toggle-password" onclick="togglePassword()" aria-label="Afficher/masquer le mot de passe">
                    <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                    <svg id="eyeOffIcon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:none;"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
                </button>
            </div>
            <input type="submit" value="Accéder" name="acces">
       </form>
       <div class="connect-footer">
           <span>Pas encore de compte ?</span>
           <a href="inscr.php" class="register-link">
               <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="8.5" cy="7" r="4"/><line x1="20" y1="8" x2="20" y2="14"/><line x1="23" y1="11" x2="17" y2="11"/></svg>
               S'inscrire
           </a>
       </div>
       </div><!-- #myconnect -->
    </div><!-- .auth-wrapper -->
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('passwordInput');
            const eyeIcon    = document.getElementById('eyeIcon');
            const eyeOffIcon = document.getElementById('eyeOffIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.style.display = 'none';
                eyeOffIcon.style.display = 'block';
            } else {
                passwordInput.type = 'password';
                eyeIcon.style.display = 'block';
                eyeOffIcon.style.display = 'none';
            }
        }
    </script>
</body>
</html>