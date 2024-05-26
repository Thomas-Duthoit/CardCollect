<?php
// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
	header("Location:../index.php?view=administration");
	die("");
}
// Si l'utilisateur n'a pas les permissions ou n'est pas connecté, on le redirige sur la page d'accueil
if (!valider("connected", "SESSION") || (valider("permissions", "SESSION") != 2)) {
	rediriger("index.php?view=accueil&");
	die("");
}

$users = listerUtilisateurs();
$questions = listerQuestions();
$boosters = listerBoosters();

$idUser = valider("idUser", "GET");
$idQuestion = valider("idQuestion", "GET");
$idBooster = valider("idBooster", "GET");
?>

<div id="administration">
    <h1>Administration</h1>
    <hr />
    <h2>Administration utilisateur</h2>
    <div>
        <?php
            mkForm();
                mkSelect("idUser[]", $users,"id", "pseudo",$idUser, "allowed");
                mkInput("submit","action","Interdire");
                mkInput("submit","action","Autoriser");
                mkInput("submit","action","Promouvoir modérateur");
                mkInput("submit","action","Promouvoir administrateur");
                mkInput("submit","action","Rétrograder");

            endForm();
            echo "<h3>Création d'un compte autorisé</h3>";
            mkForm();
                mkInput("text", "login", "", "placeholder=\"Nom d'utilisateur\"");
                mkInput("password", "passe", "", "placeholder=\"Mot de passe\"");
                mkInput("text", "email", "", "placeholder=\"Email\"");
                mkInput("submit", "action", "Créer compte");
            endForm();
        ?>
    </div>
    <hr />
    <h2>Administration questions</h2>
    <div>
        <?php
            mkForm();
                mkSelect("idQuestion[]", $questions,"id", "name", $idQuestion, "content");
                mkInput("submit", "action", "Supprimer question");
           
            endForm();

            echo "<h3>Création d'une nouvelle question</h3>";
            mkForm();
                mkInput("text", "name", "", "placeholder=\"Nom\"");
                echo "<br />";
                mkInput("text", "content", "", "placeholder=\"Intitulé\"");
                echo "<br />";
                mkInput("text", "answer", "", "placeholder=\"Réponse\"");
                echo "<br />";
                echo "Récompense : ";
                mkInput("number", "reward");
                mkInput("submit", "action", "Créer question");
            endForm();
        ?>
    </div>
    <hr />
    <h2>Administration boosters</h2>
    <div>
        <?php
            mkForm();
            mkSelect("idBooster[]", $boosters,"id", "name", $idBooster, "inShop");
            mkInput("submit", "action", "Supprimer booster");
            endForm();
           
            echo "<h3>Création d'un nouveau booster</h3>";
            mkForm();
                mkInput("text", "name", "", "placeholder=\"Nom\"");
                echo "<br />";
                echo "Prix : ";
                mkInput("number", "cost");
                echo "<br />";
                echo "nb Commun: ";
                mkInput("number", "nbCommon", "", "value=\"0\"");
                echo "nb Non-commun : ";
                mkInput("number", "nbUncommon", "", "value=\"0\"");
                echo "nb Epic : ";
                mkInput("number", "nbEpic", "", "value=\"0\"");
                echo "nb Légendaire : ";
                mkInput("number", "nbLegendary", "", "value=\"0\"");
                echo "nb random : ";
                mkInput("number", "nbRandom", "", "value=\"0\"");
                echo "<br />";
                mkInput("submit", "action", "Créer booster");
            endForm();
        ?>
    </div>
    <hr />

</div>
