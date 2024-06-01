var toReveal = document.getElementsByClassName("card_to_reveal");
var opDiv = document.getElementById("opening");

var tmpArray = Array();
for (var i=0; i<toReveal.length; i++) {
    tmpArray.push(toReveal[i]);
}
toReveal = tmpArray

var idx = toReveal.length-1;

opDiv.onclick = () => {
    if (idx==-1) {
        location = "index.php?view=boosterInventory";
    } else {
        toReveal[idx].style.animation = "linear 5s forwards reveal";
        idx--;
    }
}