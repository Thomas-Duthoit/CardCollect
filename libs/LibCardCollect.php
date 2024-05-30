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



?>