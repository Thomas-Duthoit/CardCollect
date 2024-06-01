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

$cardInv = cardInventory(valider("idUser", "SESSION"));

echo "<div style=\"margin-bottom: 20px; margin-top: 90px\">";
echo "<h2 style=\"display: inline-block; margin-left: 10px\">Mes cartes</h2>";
echo "<a class=\"crimson_button\" style=\"display:inline-block; margin-left: 20px;\" href=\"index.php?view=publication\">Créer les miennes</a>\n";
echo "<a id=\"switch_vue\" href=\"index.php?view=boosterInventory\">Voir mes boosters</a>\n";
echo "</div>";

echo "<hr />";
echo "<div class=\"booster_inv\">";
for ($i=0; $i < count($cardInv) ; $i++) {
	echo "<div class=\"popup_trigger\" onclick=\"popup_open(".$i.")\">";
    mkCard($cardInv[$i]["rarity"], $cardInv[$i]["minia_path"],$cardInv[$i]["name"]);
	echo "</div>";
}
echo "</div>";
?>

<!--- POPUP --->
<div id="popup">
	<img src="ressources/cross_icon.png" alt="cross icon" id="popup_cross" onclick="popup_close()" />
		<div id="popup_content">
		</div>
		<div id="popup_options">
		</div>
</div>

<script>

		cards_infos = <?php echo json_encode($cardInv)?>

		function popup_open(i) {
			console.log("fonction popup_open");
			console.log(cards_infos[i]);
			popup = document.getElementById("popup");
			popup_content = document.getElementById("popup_content");
			popup_options = document.getElementById("popup_options");

			popup_content.innerHTML = "<img src=img/"+cards_infos[i]["poster_path"]+" alt=\"popup poster carte\" id=\"popup_poster\">";
			popup_content.innerHTML = popup_content.innerHTML + "<h2>"+ cards_infos[i]["name"]+"</h2>";
			popup_content.innerHTML = popup_content.innerHTML + "<p>"+ cards_infos[i]["description"]+"<p>";

			popup_options.innerHTML = "<a href=\"img/"+cards_infos[i]["poster_path"]+"\" download=\""+cards_infos[i]["name"]+"\">" +
									  "<img src=\"ressources/download_icon.png\" alt=\"download_icon\" id=\"popup_download\">";
		
			popup.style.display = "block";
		}

		function popup_close() {
			console.log("fonction popup_close");
			popup = document.getElementById("popup");
			popup.style.display = "none";
		}

</script>
