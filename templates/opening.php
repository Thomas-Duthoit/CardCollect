<?php

// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
	header("Location:../index.php?view=opening");
	die("");
}
// Si l'utilisateur n'a pas les permissions ou n'est pas connecté, on le redirige sur la page d'accueil
if (!valider("connected", "SESSION")) {
	rediriger("index.php?view=accueil&");
	die("");
}

if (!($cards = valider("cards", "GET"))) {
	rediriger("index.php?view=accueil&");
	die("");
}



echo "<div class=\"radial_bg\" id=\"opening\">";
for ($i=0; $i<count($cards);$i++) {
    $data = cardInfo($cards[$i]);
    mkCardOpening($i, $data);
}
echo "</div>";
?>