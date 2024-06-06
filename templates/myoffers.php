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
foreach($offers as $o) {
	
}
?>