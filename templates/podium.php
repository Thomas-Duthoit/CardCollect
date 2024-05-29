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



$podium = classement();

echo "<div>";
    echo "<h2 class=\"podium_titre\">Classement</h2>";
	for ($i=0; $i<count($podium); $i++) {
		mkPodium ($i+1, $podium[$i]);
	}
echo "</div>";
?>