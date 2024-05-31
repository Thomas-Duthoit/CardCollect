<?php
// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
	header("Location:../index.php?view=moderation");
	die("");
}
// Si l'utilisateur n'a pas les permissions ou n'est pas connecté, on le redirige sur la page d'accueil
if (!valider("connected", "SESSION") || (valider("permissions", "SESSION") < 1)) {
	rediriger("index.php?view=accueil&");
	die("");
}

$publications = listerPublications();

echo "<div style=\"padding-left: 50px;\">";
for ($i=0; $i < count($publications) ; $i++) {
    mkPublication($publications[$i]["id"],$publications[$i]["minia_path"], $publications[$i]["poster_path"], $publications[$i]["name"], $publications[$i]["description"], getUsername($publications[$i]["idCreator"]));
}
echo "</div>";

?>