<?php 


if (isset($_POST['user_email']) && isset($_POST['user_pass'])) { // le if commence si user_pass 
    $user_email = htmlentities(strtolower($_POST['user_email']));
    $user_pass  = htmlentities($_POST['user_pass']);
    $handle = "./data/comptes.csv";
    $h = fopen($handle, "r");

    while (($data = fgetcsv($h, 1000, ";")) !== FALSE){
        if($user_email == $data[3] && password_verify($user_pass, $data[4]) ==TRUE ){
            $_SESSION['mail'] = $user_email;
            $_SESSION['nom'] = $data[1];
            $_SESSION['image'] = $data[5];
            header('Location: index.php?page=accueil');
            exit(); // header ne quitte pas proprement le fichier et du coup mettre exit() permet de s'assurer que le fichier s'arrete
        }  
        else {
            $error = "Il semblerait que ce ne soient pas vos coordonnées. <br> Veuillez réessayer.";
        }
    }

    fclose($h);
}
unset($_SESSION['mail']);

?>

<main id="login-main">

    <figure id="landing-picture-box">
        <img id="landing-picture" src="issets/landing_page.jpg" alt="desk picture">
    </figure>

    <div>
        <div>
        <h1>CONNEXION</h1>
    <?php 
    if (isset($error)) {
        echo('<p class="error-message">'.$error.'</p>');
    }
    ?>
        <form id="login-form" action="?page=login" method="POST">
        <div>
            <label>Email :</label>
            <input type="text" name="user_email"  placeholder="Enter Email">
        </div>
        <div>
            <label>Mot de passe :</label>
            <input name="user_pass" type="password"  placeholder="Enter Password">
        </div>
        <div>
            <input type="submit" name="submit" value="Submit" />
        </div>
            
        </form>
        </div>
        
    </div>
</main>
    
    


