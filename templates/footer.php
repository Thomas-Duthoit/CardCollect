<?php

// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
	header("Location:../index.php");
	die("");
}

?>
<div style="height: 500px"></div>
<div id="site_footer">

<div>© BERESZYNSKI Ewen - DUTHOIT Thomas</div>
<?php
//Si l'utilisateur est connecte, on affiche un lien de deconnexion 
if (valider("connected", "SESSION")) {
  echo "<a id=\"site_logout\" href=\"controleur.php?action=Déconnexion\">Déconnexion</a>\n";
}

?>

</div>

</body>
</html>
