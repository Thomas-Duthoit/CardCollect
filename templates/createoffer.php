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
        Création d'une offre :
    </h2>
</div>
<div style="height:100px"></div>

<?php

$cardsToSell = cardsToSell($idUser);
//tprint($cardsToSell);


mkForm("controleur.php");
	echo "<div class=\"create_top\">";
	echo "Selectionnez la carte que vous proposez  ";
	mkSelect("cardToSell", $cardsToSell, "id", "name", "", "rarity");
	echo "</div>";
	echo "<div class=\"create_left\">";
	echo "<h2>Si c'est une vente</h2>";
	echo "<p>Sélectionner le prix de vente</p>";
	mkInput("number", "cost", "");
	echo "<br />";
	mkInput("submit", "action", "Publier Vente");
	echo "</div>";
	echo "<div class=\"create_right\">";
	echo "<h2>Si c'est un échange</h2>";
	echo "<p>Sélectionner la carte voulue</p>";
	mkSelect("tradedCardId", listerCardsMarket(), "id", "name", "", "rarity");
	echo "<br />";
	mkInput("submit", "action", "Publier Echange");
	echo "</div>";


endForm();


?>