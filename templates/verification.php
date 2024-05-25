<?php

// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
	header("Location:../index.php?view=verification");
	die("");
}

?>

<div class="radial_bg">



<div id="formLogin">
	<h1>Vérification terminée !</h1>
	<p>Votre compte a été vérifié ! Redirection vers la page de connexion...</p>
</div>


</div>
