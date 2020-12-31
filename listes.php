<?php
if(!isset($_SESSION['mail'])){
    header('Location: index.php?page=login');
}
$data = get_account_from_csv();


if (isset($_REQUEST['suppress'])){
    $index  = $_REQUEST['suppress'];
    global $csv_file;

    if(isset($data[$index])) {
        unset($data[$index]);
        $fichier = fopen("$csv_file","w" )or die("Erreur fopen");
        foreach ($data as $fields) {
            fputcsv($fichier, $fields, ";");
        }
        
        fclose($fichier);
        header('Location: index.php?page=listes');
        die;
    }
    }
    
?>


<h2>Liste des administrateurs</h2>

    <main id="main_list">
        <?php
        if($_SESSION['mail']=="pierre.velon@eemi.com"){
            echo(get_table_admin($data));
        }
        else
        {
            echo(get_table_user($data));
        }
        ?>
    </main>
