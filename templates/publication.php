<?php
// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
	header("Location:../index.php?view=publication");
	die("");
}
// Si l'utilisateur n'a pas les permissions ou n'est pas connecté, on le redirige sur la page d'accueil
if (!valider("connected", "SESSION")) {
	rediriger("index.php?view=accueil&");
	die("");
}
?>

<div id="form_publication">
    <h1>Publier une carte</h1>
    <?php
        mkform("controleur.php", "post", "enctype=\"multipart/form-data\"");
        echo "Miniature : ";
        mkInput("file", "minia", "id=\"MiniaToUpload\"");
        echo "<br />";
        echo "Poster : ";
        mkInput("file", "poster", "\"\"", "id=\"PosterToUpload\"");
        echo "<br />";
        mkInput("text", "name", "", "placeholder=\"Nom\"");
        mkInput("text", "description", "", "placeholder=\"Description\"");
        echo "<br />";
        echo "Rareté : ";
        mkInput("number", "rarity", "", "min=\"0\" max=\"3\"");
        echo "<br />";
        mkInput("submit", "action", "Publier", "class=\"crimson_button\"");
        endForm();
    ?>
</div>
<div style="display: inline-block;">
    <h1>Règles</h1>
    <p>La miniature doit faire une taille de 300x300 px. Les posters font maximum du 4K et le nom de la carte ne doit pas contenir d'espace.</p>
    <p>Les cartes ne doivent contenir aucun contenu explicite.</p>
    <p>Elles ne doivent pas non plus avoir une orientation politique ou quelconque forme de haine.</p>
    <p>Tout manquement à ces règles encoureront des sanctions.</p>
</div>