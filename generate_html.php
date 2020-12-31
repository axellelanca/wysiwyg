<?php
if(!isset($_SESSION['mail'])){
    header('Location: index.php?page=login');
}


$title_page = '';
$title = '';
$description = '';
$name_file = '';
$main_content= '';

if(!empty($_POST)){

    $name_file = ($_POST['namefile']);
    $title_page = ($_POST['pagename']);
    $title = ($_POST['title']);
    $main_content = ($_POST['maincontent']);
    $description = ($_POST['description']);
    
    
    if($name_file == '' or $title_page =='' or $title == '' or $main_content == '' or $description == ''){ // check that all inputs are completed
        $error = "Tous les champs sont obligatoires !";
    }elseif(empty($error)){ //If there is no error
        if(new_name_html($name_file) == FALSE){ // Check if there is a special character
            $probleme = "Pas de caractères spéciaux SVP";
        }else{
            $name_file = new_name_html($name_file);  // We set up the new name of the file
            $fichier = fopen("./html_files/$name_file","a+" )or die("Erreur fopen"); // Create and open a new file
            $content = generate_html_content($title_page, $title, $main_content, $description); // Content that we will put in the html file
            if (!fwrite($fichier,$content)) 
            {
            echo "Erreur fwrite";
            }
            if (!fclose($fichier))
            {
                echo "Erreur fclose";
            }
            $reussite = "Le fichier a été crée avec succes";
            }
    }
}

?>

    <h2>Créer une page HTML</h2>

    <?php

    if(isset($error)){
        echo('<p class="message-error">'.$error.'</p>');
    }elseif(isset($success)){
        echo('<p class="message-error">'.$success.'</p>');
    }elseif(isset($probleme)){
        echo('<p class="message-error">'.$probleme.'</p>');
    }elseif(isset($reussite)){
        echo('<p class="message-error">'.$reussite.'</p>');
    }
    ?>
    <form method="post" action="?page=generate_html" id="form-html">
        <div>
            <label for="namefile">Nom du fichier</label>
            <input type="text" name="namefile" id="namefile">
        </div>
        <div>
            <label for="pagename">Nom de la page</label>
            <input type="text" name="pagename" id="pagename">
        </div>
        <div>
            <label for="description">Description de la page</label>
            <input type="text" name="description" id="description">
        </div>
        <div>
            <label for="title">Titre de la page</label>
            <input type="text" name="title" id="title">
        </div>

        <textarea name="maincontent" id="namecontent" cols="30" rows="10">Welcome</textarea>
        <script>
    tinymce.init({
    selector: 'textarea',
      plugins: 'a11ychecker advcode casechange formatpainter linkchecker lists checklist media mediaembed pageembed permanentpen powerpaste table advtable tinycomments tinymcespellchecker',
      toolbar: 'a11ycheck addcomment showcomments casechange checklist code formatpainter pageembed permanentpen table',
      toolbar_drawer: 'floating',
      tinycomments_mode: 'embedded',
      tinycomments_author: 'Author name',
    });
  </script>
        <div>
            <input type="submit" value="Envoyer">
        </div>
    </form>
