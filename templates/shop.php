<?php
// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
	header("Location:../index.php?view=shop");
	die("");
}
// Si l'utilisateur n'a pas les permissions ou n'est pas connecté, on le redirige sur la page d'accueil
if (!valider("connected", "SESSION")) {
	rediriger("index.php?view=accueil&");
	die("");
}


$boosters = listerboosters(1);

echo "<div>";
for ($i=0; $i < count($boosters); $i++) {
	echo "<a href=\"index.php?view=boosterinfo&idBooster=" . $boosters[$i]["id"]. "\">";
	mkBooster($boosters[$i]["name"], $boosters[$i]["cost"] . " Coins");
	echo "</a>";
}
echo "</div>";
?>