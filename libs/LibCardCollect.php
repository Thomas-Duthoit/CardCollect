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
    echo "<div class=\"card r" . $rarity . "\">";
        echo "<img src=\"./img/" . $img . "\" alt=\"miniature\">";
        echo "<p>" . $nom . "</p>";
    echo "</div>";
}

function mkBooster($name, $cost){
    echo "<div class=\"booster\">";
        echo "<span>" . $name . "</span>";
        echo "<p>". $cost . "</p>";
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



?>