<?php
if(!isset($_SESSION['mail'])){
    header('Location: index.php?page=login');
}

$errors =  []; // Definit les variables que l'on va associer à nos $_POST 
$surname = htmlentities($_POST["surname"]) ?? '';
$name = htmlentities($_POST["name"]) ?? '';
$email = htmlentities($_POST["email"]) ?? '';
$civilite = htmlentities($_POST["civilite"]) ?? null; // ?? permet de donner la valeur '' ou null si jamais $_POST['surname(par exemple)'] n'est pas definit
$password = htmlentities($_POST["password"]) ?? '';
$file = $_FILES['user_photo'] ?? '';
$file_tmp_name = $_FILES['user_photo']['tmp_name'] ?? '';
$err = [];


if(!empty($_POST)){
    //check surname is set
    if($surname =='') {
        $errors[] = 'Merci d\'indiquer votre prénom';
        $err[] = 'surname';
    }
    //check name is set
    if($name ==''){
        $errors[] = 'Merci d\'indiquer votre nom';
        $err[] = 'name';
    }
    // Check that there is no numbers in the name or surname
    if(numbers($name) or numbers($surname)){
        $errors[] = ' Merci de ne pas mettre de chiffre dans votre prénom et/ou nom' ;
        $err[] = 'name surname';
    }


    //check for a valid email address
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $errors[] = 'Merci de renseigner une adresse email valide';
        $err[] = 'email';
    } // Check if a civility is checked
    if($civilite == null){
        $errors[] = 'Merci d\'indiquer votre civilité';
    }
    $msg=format_pass($password);
    if(!empty($msg)){ 
        $errors = array_merge($errors,$msg) ; // fusionne mon premier tableau errors avec mon tableau msg qui contient mes erreurs mdp pour que je puisse afficher toute mes erreurs dans un seul et meme tableau
        $err[] = 'password';
    }
    
    if(email_exists($email)){ 
        $errors[] = "L'email est deja utilisé" ;
        $err[] = 'email';
    }

    
    if(empty($errors) && check_info_image($file)){
        $picture_name = new_name_csv($file, $surname);
        $file_destination = 'images/'.$picture_name;
        $password=hash_pass($password); //hash le mot de passe avant d'etre mis dans le fichier csv
        move_uploaded_file($file_tmp_name, $file_destination);
        $fichier = fopen("data/comptes.csv","a" );
        echo($fichier);
        $content = $civilite.";".$surname.";".$name.";".$email.";".$password.";".$picture_name."\n";

        if (!fwrite($fichier,$content)) 
        {
            echo "Erreur fwrite";
        }
        if (!fclose($fichier))
        {
            echo "Erreur fclose";
        }
        $succes = "Le compte a été crée avec succes";
        unset($_POST);
    }else{
        $probleme = check_info_image($file);
    }
}
?>
<h2>Créer un nouveau compte</h2>

<?php 

    if(empty($error) or !isset($probleme)){
        echo('<div class="message-error">');
    
    foreach ($errors as $error ){
        echo ('<p>'.$error.'</p>');
    }

    if(isset($probleme)){
        echo('<p>'.$probleme.'</p>');
    }elseif(isset($succes)){
        echo('<p>'.$succes.'</p>');
    }
    echo('</div>');
}
?>
<form action="?page=register" method="post" enctype="multipart/form-data" id="register-form"> <!-- action sur la page register et toujour method post -->
    <div>
        
        <label >Civilité :</label>
        <input type="radio" name="civilite" value="1" id="civilite" <?php if( $civilite == '1') echo 'checked' ?> /> <label>Monsieur</label>
        <input type="radio" name="civilite" value="2" id="civilite" <?php if( $civilite == '2') echo 'checked' ?> /> <label>Madame</label>
    </div>

    <div>
        <label>Prénom :</label>
        <input type="text" name="surname" placeholder="Votre Prénom" class="<?php if (in_array('surname', $err)) echo("error"); ?>"value="<?= $surname; ?>"/>
    </div>
    <div>
        <label>Nom :</label>
        <input type="text" name="name" placeholder="Votre nom" class="<?php if (in_array('name', $err)) echo("error"); ?>"  value="<?php echo $name; ?>" />
    </div>
    <div>
        <label>Email :</label>
        <input type="text" name="email"  placeholder="Votre Email" class="<?php if (in_array('email', $err)) echo("error"); ?>"  value="<?php echo $email; ?>" />
    </div>

    <div>
        <label>Mot de Passe :</label>
        <input type="password" name="password" class="<?php if (in_array('password', $err)) echo("error"); ?>" placeholder="Entrez un mot de passe">
    </div>
    <div>
        <label>Photo :</label>
        <input type="file" name="user_photo">
    </div>

    <div>
        <input type="submit" name="submit" value="Enregistrer" />
        <a href="index.php?page=register" onclick = "if (!confirm('Voulez-vous reset le formulaire?')) return false;">Réinisialiser</a>
    </div>
</form>






