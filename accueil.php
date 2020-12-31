<?php 
if(!isset($_SESSION['mail'])){
    header('Location: index.php?page=login');
}

?>


<!-- This div is used to display the user surname and his picture -->
<div class="div-accueil">
    <img id="landing-user" src="./images/<?php echo($_SESSION['image']); ?>" alt="">
    <h2 id="landing-title">Bienvenue, <?php echo($_SESSION['nom']);?> !</h2>
</div>

<main class = "main-wrapper">
    <div>
        <figure>
            <img src="issets/new_admin.jpg" alt="">
        </figure>
        <div>
            <p><a href="index.php?page=register">Nouvel admin</a></p>
        </div>
    </div>

    <div>
        <figure>
            <img src="issets/admin_list.jpg" alt="">
        </figure>
        <div>
            <p><a href="index.php?page=listes">Liste des admin</a></p>
        </div>
    </div>

    <div>
        <figure>
            <img src="issets/new_html.jpg" alt="">
        </figure>
        <div>
            <p><a href="index.php?page=generate_html">Créer une page HTML</a></p>
        </div>
    </div>
</main>

