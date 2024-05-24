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
	<title>CardCollect ...</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">

</head>
<!-- **** F I N **** H E A D **** -->


<!-- **** B O D Y **** -->
<body>


<div id="site_header">

<a href="FAIRE LE LIEN"> CardCollect <a>

<a class="crimson_button" href="index.php?view=accueil">Accueil</a>

<?php
//Si l'utilisateur n'est pas connecte, on affiche un lien de connexion 

if (!valider("connecte", "SESSION")) {
  echo "<a href=\"index.php?view=login\">Connexion</a>\n";
}

if (valider("connecte", "SESSION")) {
  echo "<a href=\"index.php?view=conversations\">Conversations</a>\n";
}

?>


</div>

<?php

if ($message = valider("message", "GET")) {
  echo "<div id=\"message\">$message</div>\n";
}

?>










