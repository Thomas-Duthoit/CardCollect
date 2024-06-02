<?php

// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
	header("Location:../index.php");
	die("");
}

// Pose qq soucis avec certains serveurs...
echo "<?xml version=\"1.0\" encoding=\"utf-8\" ?>";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<!-- **** H E A D **** -->
<head>	
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>CardCollect</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">

</head>
<!-- **** F I N **** H E A D **** -->


<!-- **** B O D Y **** -->
<body>


<div id="site_header">
	<a id="site_logo" href="index.php?view=accueil">CardCollect</a>

<?php
//Si l'utilisateur n'est pas connecte, on affiche un lien de connexion et d'inscription
echo "<div id=\"navbar_buttons\">";
	if (!valider("connected", "SESSION")) {
		echo "<a class=\"crimson_button\" href=\"index.php?view=login\">Connexion</a>\n";
		echo "<a class=\"crimson_button\" href=\"index.php?view=register\">Inscription</a>\n";
	}
	else {  // si on est connecté:
		echo getCoins(valider("idUser", "SESSION")) . " Coins";
		echo "<a class=\"more_coins_btn\" href=\"index.php?view=questions\">+</a>\n";
		echo "<a class=\"crimson_button\" href=\"index.php?view=shop\">Achat Boosters</a>\n";
		echo "<a class=\"crimson_button\" href=\"index.php?view=podium\">Classement</a>\n";
		echo "<a class=\"crimson_button\" href=\"index.php?view=cardInventory\">Inventaire</a>\n";
	}
	if (valider("connected", "SESSION") && (valider("permissions", "SESSION") >= 1)) {
		echo "<a class=\"crimson_button\" href=\"index.php?view=moderation\">Modération</a>\n";
	}
	
	if (valider("connected", "SESSION") && (valider("permissions", "SESSION") == 2)) {
		echo "<a class=\"crimson_button\" href=\"index.php?view=administration\">Administration</a>\n";
	}

echo "</div>";
?>

</div>
<div class="spacer"></div>

<?php

if ($message = valider("message", "GET")) {
  echo "<div id=\"message\">$message</div>\n";
}

?>










