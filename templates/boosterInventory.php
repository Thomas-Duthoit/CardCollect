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
$boosters = boosterInventory($idUser);

echo "<div style=\"margin-bottom: 20px; margin-top: 90px\">";
echo "<h2 style=\"display: inline-block; margin-left: 10px\">Mes boosters</h2>";
echo "<a id=\"switch_vue\" href=\"index.php?view=cardInventory\">Voir mes cartes</a>\n";
echo "</div>";

echo "<hr />";
echo "<p class=binv_info>Clique sur un booster pour l'ouvrir!</p>";
echo "<div class=\"booster_inv\">";
foreach ($boosters as $b) {
	mkBooster($b["name"], 0, $b["nbCarte"]);
}
echo "</div>";
?>