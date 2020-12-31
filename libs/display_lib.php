<?php

/* 
    * Fonction pour inclure le head dans la page
    * Paramètres de la fonction:
    * $meta: tableau indéxé numériquement avec la liste des meta nécessaires
    * $title_page : titre de la page
    * $link : tableau avec deux clés: rel et file qui permettent d'inclure un ou plusieurs fichier css (ou autre)
    * Return : $html : code HTML qui va être généré
*/
function generate_head($meta, $title_page, $link){
    $html = "<head>";
    
    for ($i = 0; $i < count($meta); $i++){
        $html .= "<meta ".$meta[$i].">";
    }

    foreach($link as $file){
        $html .= "<link rel= \"".$file["rel"]."\" href=\"".$file["file"]."\">";
    }
    $html .= "<script src=\"https://cdn.tiny.cloud/1/vtm96wwewh59yui6tbzdbnl5k648kldyg5vmfa6q67mjvkbp/tinymce/5/tinymce.min.js\" referrerpolicy=\"origin\"></script>";

    $html .= "<title>".$title_page."</title></head>";
    return $html;
}

/* 
    * Fonction pour inclure le header, logo + menu 
    * Les paramètres de la fonction: 
    * $img_source : source de l'image voulue, en local ou URL
    * $img_alt: le message alternatif à défaut de l'affichage de l'image
    * $title_h1 : choix du h1 
    * $nav_list : array, choix de tous les éléments nécessaires à la navbar / menu
    * Return : $html : code html qui sera généré grâce à la fonction.
*/
function generate_header($img_source, $img_alt, $title_h1, $nav_list){
    $html = "<header>
                <div>
                    <figure>
                        <img src = \"".$img_source."\" alt = \"".$img_alt."\">
                    </figure>
                    <h1>".$title_h1."</h1>
                </div>
                <nav>
                    <ul>";
    
    for($i = 0; $i < count($nav_list); $i++){
        $html .= "<li>".$nav_list[$i]."</li>";
    }

    $html .= "</ul>
    </nav>
    </header>";

    return $html;
}

function generate_p($content, $class){
    $html = "<p class= \"".$class."\">".$content."</p></p>";
    return $html;
}

// Fonction pour inclure le footer

function section_footer(){
    echo("
        <footer>
            <p>Tous droits réservés</p>
            <p>©</p>
        </footer>
        ");
} 


/*
    * Fonction pour faire apparaitre les "cartes" des users enregistrées
    * Juste pour l'admin car contient la ligne de suppression
*/
function get_table_admin($table){
    $html = '';
    foreach ($table as $infos => $info){
        $html .= "<article>
        <figure class=\"user_photo\">
            <img src=\"./images/".($info['5'])."\">
        </figure>
        <div class=\"user_profile\">
        <p>".$info['2']."</p>
        <p>".$info['1']."</p>
        <p>".$info['3']."</p>
        <p><a href=\"index.php?page=listes&suppress=".$infos. "\" onclick = \"if (! confirm('Continue?')) return false;\">Supprimer</a></p>
        </div>
        </article>";
    }
    return $html;
}

/*
    * Fonction pour afficher les administrateurs, sans la ligne suppression
*/
function get_table_user($table){
    $html = '';
    foreach ($table as $info){
        $html .= "<article>
        <figure class=\"user_photo\">
            <img src=\"./images/".($info['5'])."\">
        </figure>
        <div class=\"user_profile\">
        <p>".$info['2']."</p>
        <p>".$info['1']."</p>
        <p>".$info['3']."</p>
        </div>
        </article>";
    }
    return $html;
}

?>