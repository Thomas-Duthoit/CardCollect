<?php
// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
	header("Location:../index.php?view=cardInventory");
	die("");
}
// Si l'utilisateur n'a pas les permissions ou n'est pas connecté, on le redirige sur la page d'accueil
if (!valider("connected", "SESSION")) {
	rediriger("index.php?view=accueil&");
	die("");
}

$idUser = valider("idUser", "SESSION");
?>
<div id="market_top">
    <h2>
        Offres du marché - cliquez sur une offre pour l'acheter !
    </h2>
	<a class="crimson_button" href="index.php?view=myoffers">Mes offres en cours</a>
</div>
<div style="height:100px"></div>

<?php 

$offers = listerToutesLesOffresSaufUser($idUser);
//tprint($offers);

foreach($offers as $o) {
    mkOffer($o);
}
if (count($offers) == 0) {
	echo "<h1 style=\"width:100vw;text-align:center;color:var(--dark)\">Aucune offre pour le moment...</h1>";
}

?>


<div id="market_bottom">
    <p>Vous voulez vendre ou échanger vos cartes ?</p>
	<a class="crimson_button" href="index.php?view=createoffer">Faire une offre</a>
</div>
