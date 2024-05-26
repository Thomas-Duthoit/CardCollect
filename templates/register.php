<?php

// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
	header("Location:../index.php?view=register");
	die("");
}

// Si l'utilisateur est connecté, on le redirige à l'accueil.
if (valider("connected", "SESSION")) {
	rediriger("index.php?view=accueil&");
	die("");
}
?>

<div class="radial_bg">



<div id="formLogin">
	<h1>Inscription</h1>
	<?php
		mkForm();
			mkInput("text", "login", "", "placeholder=\"Nom d'utilisateur\"");
			mkInput("password", "passe", "", "placeholder=\"Mot de passe\"");
			mkInput("text", "email", "", "placeholder=\"Email\"");
			mkInput("hidden", "view", "register");
			mkInput("submit", "action", "Inscription", "style=\"position:relative;top:20px;left:0px\"");
		endForm();
	?>
</div>


</div>
