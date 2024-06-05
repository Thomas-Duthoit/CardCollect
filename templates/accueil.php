<?php


if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
	header("Location:../index.php?view=accueil");
	die("");
}

?>


<div id="corps">

	<h1>Accueil</h1>

	Bienvenue dans notre site de collection de cartes !

	<hr />
	<div id="info1">
		<img src="ressources/Card.png" alt="Image de carte">
		<span style="margin-left: 50px;">
			Sur ce site, ton objectif sera de faire une collection de cartes en achetant des boosters. 
			<br />Ces boosters te donneront de magnifiques cartes qui te feront monter dans le classement !
			<br />Tu pourras même créer tes propres cartes !
		</span>
	</div>
	<hr />
	<div id="info2">
		<img src="ressources/question.png" alt="Image de question">
		<span>
			Réponds à des questions sur les différentes matière de 2I !
		<br /> En plus de t'aider dans tes révisions, cela te donnera des coins pour achetes des boosters plus cher !
		</span>
	</div>
	<hr />
	<div>
		<span id="invitation">Qu'attends-tu pour nous rejoindre ?!</span>
	</div>
</div>







