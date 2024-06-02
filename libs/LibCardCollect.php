<?php

function verificationMail($id, $code, $mail, $login){

    // Récupération du lien local (UNIQUEMENT DANS LE CADRE DU PROJET)
    $pieces = explode('?', $_SERVER['HTTP_REFERER']);

    // Création du lien de validation
    $link = $pieces[0] ."view=verification&id=" . $id ."&code=" . $code;

    // Rédaction du message 
    if (mail($mail, "Verification", "Ton lien:".$link, "From:"."CardCollect@noreply.com")) {
        die("OK");
    }
    else{
        die("A pus");
    }
    return;
}

function mkCard($rarity, $img, $nom){
    echo "<div class=\"card r" . $rarity+1 . "\">";
        echo "<img src=\"img/" . $img . "\" alt=\"miniature\">";
        echo "<p>" . $nom . "</p>";
    echo "</div>";
}

function mkCardOpening($i, $c, $data) {
    echo "<div class=\"card_to_reveal r" . $data["rarity"]+1 . "\" style=\"--card_idx: " . $i . "; --card_count: " . $c . "\">";
        echo "<img src=\"img/" . $data["minia_path"] . "\" alt=\"miniature\">";
        echo "<p>" . $data["name"] . "</p>";
    echo "</div>";
    echo "<div class=card_cache style=\"--card_idx: " . $i . "; --card_count: " . $c . "\">?</div>";
}

function mkBooster($name, $cost, $cardsCount="NO", $id=0){
    if ($cardsCount == "NO") {
        echo "<div class=\"booster\">";
            echo "<span>" . $name . "</span>";
            echo "<p>". $cost . "</p>";
        echo "</div>";
    } else {
        echo "<a href=\"controleur.php?action=OuvrirBooster&idBooster=" . $id . "\"><div class=\"booster\">";
            echo "<span>" . $name . "</span>";
            echo "<p>". $cardsCount . " cartes</p>";
        echo "</div></a>";
    }
}

function mkQuestion($q) {
    echo "<div class=\"question\">";
    echo "<table>";
    echo "<tr>";
    echo "<td>";
    echo "<h2>" . $q["name"] . "</h2>";
    echo $q["content"];
    echo "</td>";
    echo "<td>";
    mkForm("controleur.php");
        mkInput("text", "answer", "Votre réponse");
        mkInput("submit", "action", "Repondre");
    endForm();
    echo "</td>";
    echo "</tr>";
    echo "</table>";
    echo "</div>";
}

function mkPodium($id, $user) {
    echo "<div class=\"podium\"";
    if ($id <= 3) echo " id=\"top_$id\"";
    echo "><p>";
    echo "#$id - ";
    echo $user["pseudo"];
    echo "</p>";
    echo "<span>";
    echo "uniques : " . $user["uniques"] . "  -  total : " . $user["cards"] . "  -  coins :" . $user["coins"];
    echo "</span>";
    echo "</div>";
}

function mkPublication($id, $minia, $poster, $name, $description, $creator){
    echo "<div class=\"publication\">";
        echo "<img src=\"img/".$minia."\" alt=\"miniature publication\" class=\"publication_minia\">";
        echo "<img src=\"img/".$poster."\" alt=\"poster publication\" class=\"publication_poster\">";
        echo "<div class=\"publication_infos\">";
            echo    "<span>Nom : ".$name."</span>";
            echo     "<p>Description : ".$description."</p>";
            echo     "<span>Crée par : ".$creator."</span>";
        echo "</div>";
            echo "<div class=\"publication_choice\">";
                echo "<a style=\"margin-right:10px;\" href=\"controleur.php?action=AccepterPublication&idPublication=".$id."\">";
                echo "<img src=\"ressources/check_icon.png\" alt=\"check_icon\">";
                echo "</a>";
                echo "<a href=\"controleur.php?action=RefuserPublication&idPublication=".$id."\">";
                echo "<img src=\"ressources/cross_icon.png\" alt=\"cross_icon\">";
                echo "</a>";
            echo "</div>";
    echo "</div>";
}

?>