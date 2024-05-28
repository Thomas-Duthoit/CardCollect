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

$booster = infoBooster(valider("idBooster", "GET"));
echo "<div style=\"margin-left: 10px;\">";
    echo "<h1>".$booster[0]["name"]." : " . $booster[0]["cost"] . " Coins </h1>";
    echo "<hr />";
    echo "<div>";
    echo "<div class=\"boosterContent r1\">" . "Nombre commun : " . $booster[0]["nbCommon"] . "</div>";
    echo "<div class=\"boosterContent r2\">" . "Nombre non-commun : " . $booster[0]["nbUncommon"] . "</div>";
    echo "<div class=\"boosterContent r3\">" . "Nombre epic : " . $booster[0]["nbEpic"] . "</div>";
    echo "<div class=\"boosterContent r4\">" . "Nombre légendaire : " . $booster[0]["nbLegendary"] . "</div>";
    echo "<div class=\"boosterContent random\">" . "Nombre random : " . $booster[0]["nbRandom"] . "</div>";
    echo "</div>";
    echo "<hr />";
    mkForm();
        mkInput("submit", "action", "Acheter booster", "class=\"crimson_button\"");
        mkInput("hidden", "idBooster", $booster[0]["id"]);
        mkInput("hidden", "cost", $booster[0]["cost"]);
        mkInput("hidden", "view", "shop");
    endForm();
echo "</div>";
?>

