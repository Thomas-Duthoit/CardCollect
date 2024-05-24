<?php

// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
	header("Location:../index.php?view=register");
	die("");
}

?>

<div class="radial_bg">



<div id="formLogin">
	<h1>Inscription</h1>
	<?php
		mkForm();
		mkInput("text", "login", "");
		endForm();
	?>
</div>


</div>
