<?php

include_once "maLibSQL.pdo.php";

/* ----------- ! USERS ! ----------- */

// Vérifie si l'utilisateur est dans la BDD
function verifUserBdd($login, $passe)
{
  return SQLGetChamp("
    SELECT id
    FROM Users
    WHERE pseudo='$login'
      AND pass='$passe';
  ");
}

// Récupère les permissions d'un utilisateur
function getPermission($id){
    return SQLGetChamp("
        SELECT privileges
        FROM Users
        WHERE id='$id';
    ");
}

// Vérifie si le pseudo est déjà utilisé
function usernameExists($login){
    return SQLGetChamp("
        SELECT id
        FROM Users
        WHERE pseudo='$login';");
}

// Vérifie si l'email est déjà utilisé
function emailExists($email){
    return SQLGetChamp("
        SELECT id
        FROM Users
        WHERE mail='$email';");
}

// Permet de créer un utilisateur
function createUser($login, $passe, $mail){
    return SQLInsert("
        INSERT INTO Users(mail, pseudo, pass)
        VALUES('$mail', '$login', '$passe');");
}

// Récupère l'ID d'un utilisateur avec son pseudo
function getId($login){
    return SQLGetChamp("
    SELECT id
    FROM Users
    WHERE pseudo='$login';");
}

// Créer une vérification.
function createVerif($id, $code){
    return SQLInsert("
        INSERT INTO Verification(idUser, code)
        VALUES('$id', '$code');");
}

// Liste les utilisateurs
function listerUtilisateurs($classe = "both")
{
	$etat_blacklist = ";";
	if ($classe == "bl") {
	  $etat_blacklist = "WHERE NOT allowed;";
	}
	if ($classe == "nbl") {
	  $etat_blacklist = "WHERE allowed;";
	}
  $sql = "
    SELECT id, pseudo, allowed
    FROM Users
    $etat_blacklist
  ";
  return parcoursRs(SQLSelect($sql));
}

function getCoins($id){
  return SQLGetChamp("
  SELECT coins
  FROM Users
  WHERE id='$id';");
}






// Autorise un utilisateur
function autoriserUtilisateur($idUser)
{
	return SQLUpdate("
    UPDATE Users
    SET allowed = 1
    WHERE id = '$idUser';");
}

// Interdit un utilisateur
function interdireUtilisateur($idUser)
{
	return SQLUpdate("
    UPDATE Users
    SET allowed = 0
    WHERE id = '$idUser';");
}

// Promouvoie un utilisateur en tant que modérateur
function promoModerateur($idUser)
{
	return SQLUpdate("
    UPDATE Users
    SET privileges = 1
    WHERE id = '$idUser';");
}

// Promouvoie un utilisateur en tant qu'Administrateur
function promoAdmin($idUser)
{
	return SQLUpdate("
    UPDATE Users
    SET privileges = 2
    WHERE id = '$idUser';");
}

// Rétrograde un utilisateur en simple utilisateur.
function retrograde($idUser)
{
	return SQLUpdate("
    UPDATE Users
    SET privileges = 0
    WHERE id = '$idUser';");
}

/* ----------- ! QUESTIONS ! ----------- */
function listerQuestions()
{
  $sql = "
    SELECT id, name, content, answer, reward
    FROM Questions;
  ";
  return parcoursRs(SQLSelect($sql));
}

function supprimerQuestion($idQuestion)
{
    return SQLDelete("
    DELETE FROM Questions
    WHERE id='$idQuestion';");
}

function créerQuestion($name, $content, $answer, $reward)
{
	return SQLInsert("
    INSERT INTO Questions(name, content, answer, reward)
    VALUES('$name', '$content', '$answer', '$reward');");
}

/* ----------- ! BOOSTERS ! ----------- */
// Liste les boosters
function listerBoosters($inshop = 0){
    $sql = "
    SELECT id, name, cost, nbCommon, nbUncommon, nbEpic, nbLegendary, nbRandom, inShop
    FROM Boosters";
    if ($inshop == 0) {
      $sql = $sql . ";";
    }
    else {
      $sql = $sql . " WHERE inShop;";
    }

  return parcoursRs(SQLSelect($sql));
}

function créerBooster($name, $cost, $nbCommon, $nbUncommon, $nbEpic, $nbLegendary, $nbRandom){
    return SQLInsert("
    INSERT INTO Boosters(name, cost, nbCommon, nbUncommon, nbEpic, nbLegendary, nbRandom)
    VALUES('$name', '$cost', '$nbCommon', '$nbUncommon', '$nbEpic', '$nbLegendary', '$nbRandom');");
}

function supprimerBooster($idBooster)
{
    return SQLDelete("
    DELETE FROM Boosters
    WHERE id='$idBooster';");
}

function infoBooster($idBooster){
    return parcoursRs(SQLSelect("
    SELECT id, name, cost, nbCommon, nbUncommon, nbEpic, nbLegendary, nbRandom
    FROM Boosters
    WHERE id='$idBooster';"));
}

function giveBooster($idUser, $idBooster){
  return SQLInsert("
  INSERT INTO BoosterInventory(ownerId, boosterId)
  VALUES('$idUser', '$idBooster');");
}


function achat($idUser, $cost){
  return SQLUpdate("
    UPDATE Users
    SET coins = coins - '$cost'
    WHERE id = '$idUser';");
}

?>