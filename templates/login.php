<?php

// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
	header("Location:../index.php?view=login");
	die("");
}

// Chargement eventuel des données en cookies
$login = valider("login", "COOKIE");
$passe = valider("passe", "COOKIE"); 
if ($checked = valider("remember", "COOKIE")) $checked = "checked"; 

?>

<div class="radial_bg">
	<div id="formLogin">
		<h1>Connexion</h1>
		<form action="controleur.php" method="GET">
			<input type="text" id="login" name="login" value="<?php echo $login;?>" placeholder="Nom d'utilisateur"/><br />
			<input type="password" id="passe" name="passe" value="<?php echo $passe;?>" placeholder="Mot de passe"/><br />
			<input type="checkbox" <?php echo $checked;?> name="remember" id="remember" value="ok" class="crimson_cb"/>
			<label for="remember">Rester connecté</label>
			<input type="submit" name="action" value="Connexion"/>
		</form>
	</div>
</div>
