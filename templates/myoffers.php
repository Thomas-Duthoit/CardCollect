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
        Mes offres :
    </h2>
</div>
<div style="height:100px"></div>

<?php

$offers = getUserOffers($idUser);
//tprint($offers);
foreach($offers as $o) {
	$c = cardInfo(getCardCircu($o["circuId"]));
	mkCard($c["rarity"], $c["minia_path"], $c["name"]);
	if ($o["trade"]) {
		echo " echangée contre ";
		$c2 = cardInfo($o["tradedId"]);
		mkCard($c2["rarity"], $c2["minia_path"], $c2["name"]);
	} else {
		echo "vendue pour " . $o["cost"] . " coins";
	} 
	echo "<a class=\"crimson_button\" href=\"controleur.php?action=deleteOffer&offerId=" . $o["id"] . "\">Supprimer l'offre</a>\n";
	echo "<hr />";
}
?>