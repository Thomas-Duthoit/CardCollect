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

$cardInv = cardInventory(valider("idUser", "SESSION"));

echo "<div style=\"margin-bottom: 20px; margin-top: 90px\">";
echo "<h2 style=\"display: inline-block; margin-left: 10px\">Mes cartes</h2>";
echo "<a class=\"crimson_button\" style=\"display:inline-block; margin-left: 20px;\" href=\"index.php?view=publication\">Créer les miennes</a>\n";
echo "<a id=\"switch_vue\" href=\"index.php?view=boosterInventory\">Voir mes boosters</a>\n";
echo "</div>";

echo "<hr />";
echo "<div class=\"booster_inv\">";
for ($i=0; $i < count($cardInv) ; $i++) { 
    mkCard($cardInv[$i]["rarity"], $cardInv[$i]["minia_path"],$cardInv[$i]["name"]);
}
echo "</div>";
?>