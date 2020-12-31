<?php

/*
    * Function to give a new name to the file/picture uploaded by the user
    * Two parameters: $file_name = $_FILES['name']; $user_name = $_POST['nom'];
    * Return: $new_name : the new name of the file
*/
function new_name_csv($file_name,$user_name){ 
    // We create two arrays: the first one with the accents we want to remove, the second with what we want to replace them.
    $accent = array("é","è","ê","ë","ç"," ");
    $accent_none = array("e","e","e","e","c","");
    //we save the file path with pathinfo
    $extension  = pathinfo($file_name['name']);
    //We save the extension
    $extension_upload = $extension['extension'];
    //New variable $new_name with the new file name, concatenating with the user name, with a uniqid and then with the extension
    $new_name = "image-".strtolower($user_name)."-".uniqid().'.'.$extension_upload;
    //We use str-replace with the two arrays to replace accents et spaces.
    $new_name = str_replace($accent,$accent_none,$new_name);
    return $new_name;
}


/*
    * Function to give a correct name to the html file
    * Parameter : $name_file = $_POST['namefile'];
    * return : a string with the new name of the file
*/
function new_name_html($name_file){

    if (preg_match('/[^a-zA-Z\d]/', $name_file)){
        return FALSE;
    }else{
    $car_not_allowed = array("é","è","ê","ë","ç"," ","à",".","?");
    $car_allowed = array("e","e","e","e","c","_","a","",);
    $name_file = str_replace($car_not_allowed, $car_allowed, $name_file);
    $name_file = $name_file.".html";

    return $name_file;
    }
    
}

/*
    * Function to verify some conditions to validate the file we want to upload
    * Parameter: $file_name = $_FILES['nom'];
    * Return TRUE if all conditions are validated
    * Elseif return an error message depending on the problem encountered
*/ 
function check_info_image($file_name){ 
    //On récupère le name du fichier, la taille et erreur.
    $name_file = $file_name['name'];
    $file_size = $file_name['size'];
    $file_error = $file_name['error'];
    //On utilise explode pour séparer en segment le nom du fichier avec "." en séparateur.
    $file_ext = explode('.', $name_file);
    //On met en minuscule pour pouvoir vérifier l'ext, et grâce à end() on récupère le dernier élément du tableau.
    $file_actual_ext = strtolower(end($file_ext));
    //On liste les différents formats acceptés.
    $allowed_ext = array('jpeg','jpg');

    if(in_array($file_actual_ext, $allowed_ext)){ //Si extension OK
        if($file_error === 0){ // Si pas d'erreur 
            if($file_size < 900000){ // Si la taille de la photo est OK
                return TRUE; //On return TRUE, toutes les conditions ont été validées.
            }else{ //Sinon affichage de l'erreur
                return "Votre fichier est trop volumineux.";
            }
        }else{
            return "Une erreur est survenu lors du chargement de votre photo. Veuillez réessayer.";
        }
    }else{
        return "Le format de photo choisi n'est pas accepté";
    }
}



function format_pass($pass){  //fonction password qui verifie a l'aide de plusieurs autres fonction la contenance du mot de passe
    $msg = [];
    if (!numbers($pass))
        $msg[]= 'Le mot de passe doit contenir au moins un chiffre';
    if (!alpha_char($pass))
        $msg[]= 'Le mot de passe doit contenir au moins une lettre';
    if (!lower_case($pass))
        $msg[]= 'Le mot de passe doit contenir au moins une minuscule';
    if (!upper_case($pass))
        $msg[]= 'Le mot de passe doit contenir au moins une majuscule';
    if (strlen($pass) < 8)
        $msg[]= 'Le mot de passe doit contenir au moins 8 caractères';
    if (preg_match('/[^a-zA-Z\d]/', $pass) != true)
        $msg[]= 'Le mot de passe doit contenir au moins un caractère spécial';
    return $msg; // retourne msg qui contient toute nos erreurs
}

function numbers($pass){  // Fonction qui verifie si il y a un nombre en cassant la chaine de charactere ( str_split ) et en analysant grace a un foreach , si au moin un chiffre est trouvé la fonction return true , sinon elle return false
    $arr = str_split($pass);
    foreach ($arr as $char) {
        if (is_numeric($char)) {
            return true;
        }
    }
    return false;
}


function upper_case($pass){ //Fonction qui verifie si il y a une majuscule en cassant la chaine de charactere ( str_split ) et en analysant grace a un foreach , si au moin une majuscule est trouvé la fonction return true , sinon elle return false
    $arr = str_split($pass);
    foreach ($arr as $char) {  
        if (ctype_upper($char)) {
            return true;
        }
    }
    return false;
}




function lower_case($pass){ // For lowercases
    $arr = str_split($pass);
    foreach ($arr as $char) {
        if (ctype_lower($char)) {
            return true;
        }
    }
    return false;
}

/**
 * Check ifpass has a letter
 * 
 * @param  string $pass 
 * @return bool
 */
function alpha_char(string $pass): bool {
    $arr = str_split($pass);
    foreach ($arr as $char) { 
        if (ctype_alpha($char))
            return true;
    }
    return false;
}


function hash_pass($hash){ // Hash the password before it goes into the csv 
    $hash = password_hash($hash, PASSWORD_DEFAULT);
    return($hash);
}



function is_allowed($page){
    
    $shield = [ 
        'register.php',
        'table.php',
        'listes.php',
        'generate_html.php',
        'acceuil.php'
    ];

    if (in_array($page, $shield) && !isset($_SESSION['mail'])) {
        return false;
    } 

    return true;
}


function get_account_from_csv(){   
    global $csv_file;   // appel ma variable que j'ai set up dans mon index.php
    if (($h = fopen("{$csv_file}", "r")) !== FALSE) // On determine une variable $h qui sera le f open du fichier (comptes.csv) avec la variable $filename, si le resultat est different de False on passe a l'étape d'apres
    {
        while (($data = fgetcsv($h, 1000, ";")) !== FALSE)  // on cree la variable $Data qui va recuperer toutes les informations du fichier csv , on utilise fgetcsv puis $h crée precedement en parametre ( idem avec le !=== False )
        {
            $table[] = $data; // Puisque $data sort un tableau , celui va etre push dans notre varible $table 
        }
        fclose($h); // on ferme le ficheir csv 
    }
    return $table;  
}


function email_exists($email){  
    $accounts = get_account_from_csv();
    foreach ($accounts as $account) {
        if ($account[3] == $email){
            return true;
        }
    }
    return false;
}


/*
    * Fonction qui génère le contenu du fichier HTML que l'on veut créer via le formulaire
*/
function generate_html_content($title_page, $title, $main_content, $description){
    $html = '<!DOCTYPE html>
        <html>
        <head>
            <meta charset = "utf-8">
            <meta name="description" content="'.$description.'">
            <title>'.$title_page.'</title>
        </head>
        <body>
            <h1>'.$title.'</h1>
            <main>'.$main_content.'</main>
        </body>
        </html>';

        return $html;
}   

?>