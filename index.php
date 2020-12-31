<?php

session_start();

include './libs/display_lib.php';
require_once './libs/tool_lib.php';  //  comme include() mais d'assure d'importer une seule fois le fichier


$csv_file="./data/comptes.csv";
$head = ['charset="UTF-8"', 'name="viewport" content="width=device-width, initial-scale=1.0"' ];
$title_page = 'Wisiwyg';
$data = get_account_from_csv();
$link = array(
    array(
        "rel" => "stylesheet",
        "file" => "./css/style.css"
    )
    );
/**  
* Pour justifier l'utiliter d'un index.php , ca nous permet d'afficher toute 
* nos pages ici meme dans le html plus bas et egalement d'appeler nos lib uniquement ici .
* Et de plus ca nous permet de lancer une sessin start uniquement sur cette page 
*/



/**  ?page=
 * Router
 * variable req_page = une request dans l'url de page ( $_GET ) pour recuperer la page a afficher 
 * si jamais ( ?? ) $_GET[page] n'existe pas alors on prend par default login( pour juste du remplissage )
 * ensuite switch ( comme un if ) va lire la varique ($req_page) et associe le fichier php lier a la page et l'afficher plus bas dans notre html ici meme 
 */
$req_page = $_REQUEST['page'] ?? 'login';  
switch ($req_page) {
    case 'register':
        $page = 'register.php';
        break;
    case 'listes';
        $page = 'listes.php';
        break;
    case 'generate_html';
        $page = 'generate_html.php';
        break;
    case 'accueil';
        $page = 'accueil.php';
    break;
    default:
        $page = 'login.php'; // page par default 
}
    
if (is_allowed($page) === false ) {
    $page = 'login.php';
    $error = 'Log in first';
}
if (isset($_REQUEST['deco'])){
    header('Location: index.php?page=login');
}
?>

<!DOCTYPE html>
<html lang="fr">
    <?php
        echo(generate_head($head, $title_page, $link));
    ?>

    <body>
        <div>

        
        <?php if($page !== 'login.php'){
            echo ('
            <nav>
                <div class="wrapper">
                    <a id="logo" href = "#">LesBossDuPHP</a>');
                
        if($_SESSION['mail']=="pierre.velon@eemi.com"){
            echo('<p id="big-boss">Félicitations, vous êtes le big boss Admin ! </p>');
                    }
                    
            echo('<ul>');

            if($page !== "accueil.php"){ echo('<li><a href="index.php?page=accueil">Accueil</a></li>');}
                    
                        echo('<li><a href="index.php?page=listes&deco=1">Se déconnecter</a></li>
                    </ul>
                </div>
            </nav>
            ');
            }?>

    
<?php require_once $page ?>
</div>
    </body>
</html>

