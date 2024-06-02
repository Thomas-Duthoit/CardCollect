var toReveal = document.getElementsByClassName("card_to_reveal");
var cardCaches = document.getElementsByClassName("card_cache");
var opDiv = document.getElementById("opening");
var cardsRemaining = document.getElementById("cards_remaining");

var tmpArray = Array();
for (var i=0; i<toReveal.length; i++) {
    tmpArray.push(toReveal[i]);
}
toReveal = tmpArray

tmpArray = Array();
for (var i=0; i<cardCaches.length; i++) {
    tmpArray.push(cardCaches[i]);
}
cardCaches = tmpArray


var idx = toReveal.length-1;
cardsRemaining.innerHTML = idx+1 + " cartes restantes";

opDiv.onclick = () => {
    if (idx==-1) {
        location = "index.php?view=boosterInventory";
    } else {
        toReveal[idx].style.animation = "linear 5s forwards reveal";
        cardCaches[idx].style.animation = "linear 5s forwards hideCache";
        idx--;
    }
    cardsRemaining.innerHTML = idx+1 + " cartes restantes";
    if (idx == -1) {
        cardsRemaining.innerHTML = idx+1 + " cartes restantes - Cliquez n'importe où pour sortir";
    }
}