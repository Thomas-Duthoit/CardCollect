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
// Vérifie si l'utilisateur est autorisé
function isAllowed($login)
{
  return SQLGetChamp("
    SELECT allowed
    FROM Users
    WHERE pseudo='$login';
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

// Récupère le nombre de coins de l'utilisateur
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

//Obtenir le classement des 25 meilleurs utilisateurs
function classement() 
{
  $sql = "SELECT u.pseudo AS pseudo, COUNT(DISTINCT c.cardId) AS uniques, COUNT(c.cardId) AS cards, u.coins AS coins
          FROM Users AS u
          JOIN Circulation AS c
            ON u.id = c.ownerId
          GROUP BY u.pseudo
          ORDER BY COUNT(DISTINCT c.cardId) DESC,
                   COUNT(c.cardId) DESC,
                   u.coins DESC
          LIMIT 25";
  return parcoursRs(SQLSelect($sql));
}

// Récupère le pseudo d'un utilisateur selon son id
function getUsername($id){
  return SQLGetChamp("
  SELECT pseudo
  FROM Users
  WHERE id='$id';");
}

/* ----------- ! BOOSTERS ! ----------- */
// Liste les boosters (Si on ne donne pas un autre int que 0 à inshop, on liste tous les boosters, sinon que ceux dans le shop)
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

// Créer un booster
function créerBooster($name, $cost, $nbCommon, $nbUncommon, $nbEpic, $nbLegendary, $nbRandom){
    return SQLInsert("
    INSERT INTO Boosters(name, cost, nbCommon, nbUncommon, nbEpic, nbLegendary, nbRandom)
    VALUES('$name', '$cost', '$nbCommon', '$nbUncommon', '$nbEpic', '$nbLegendary', '$nbRandom');");
}

// Supprime un booster
function supprimerBooster($idBooster)
{
    return SQLDelete("
    DELETE FROM Boosters
    WHERE id='$idBooster';");
}
// Supprime un booster des inventaires.
function supprimerBoosterInv($idBooster)
{
  return SQLDelete("
  DELETE FROM BoosterInventory
  WHERE boosterId='$idBooster';");
}

// Donne les information d'un booster
function infoBooster($idBooster){
    return parcoursRs(SQLSelect("
    SELECT id, name, cost, nbCommon, nbUncommon, nbEpic, nbLegendary, nbRandom
    FROM Boosters
    WHERE id='$idBooster';"));
}

// Donne à un utilisateur un booster
function giveBooster($idUser, $idBooster){
  return SQLInsert("
  INSERT INTO BoosterInventory(ownerId, boosterId)
  VALUES('$idUser', '$idBooster');");
}

// Rend le booster disponible au shop
function ajouterShop($idBooster){
  return SQLUpdate("
  UPDATE Boosters
  SET inShop = 1
  WHERE id='$idBooster';");
}

// Rend indisponible le booster au shop
function retirerShop($idBooster){
  return SQLUpdate("
  UPDATE Boosters
  SET inShop = 0
  WHERE id='$idBooster';");
}

// Achat d'un utilisateur (NE PAS OUBLIER SI C'EST >= 0 AVANT L'ACHAT DANS LE CONTROLEUR)
function achat($idUser, $cost){
  return SQLUpdate("
    UPDATE Users
    SET coins = coins - '$cost'
    WHERE id = '$idUser';");
}

function addCoinsToUser($idUser, $amount) {
  return SQLUpdate("
  UPDATE Users
  SET coins = coins + '$amount'
  WHERE id = '$idUser';");
}

function questionDoneForUser($idUser, $idQuestion) {
  $sql = "INSERT INTO UserQuestions (userId, questionId) VALUES ('$idUser', '$idQuestion')";
  return SQLInsert($sql);
}

function isQuestionDone($idUser, $idQuestion) {
  $sql = "SELECT id FROM UserQuestions WHERE userId = '$idUser' AND questionId = '$idQuestion'";
  return parcoursRs(SQLSelect($sql));
}

/* ----------- ! INVENTORY ! ----------- */

// Liste les cartes dans l'inventaire d'un utilisateur
function cardInventory($idUser){
  return parcoursRs(SQLSelect("
  SELECT Cards.name, Cards.description, Cards.idCreator, Cards.minia_path, Cards.poster_path, Cards.rarity
  FROM Cards JOIN Circulation ON Cards.id = Circulation.cardId
  WHERE '$idUser' = Circulation.ownerId 
  AND Circulation.inMarket = 0
  ORDER BY Cards.rarity DESC, Cards.name;
  "));
}

// Liste les boosters dans l'inventaire d'un utilisateur
function boosterInventory($idUser) {
  $sql = "SELECT I.id as invId,  B.name, B.nbCommon + B.nbUncommon + B.nbEpic + B.nbLegendary + B.nbRandom as nbCarte
          FROM BoosterInventory as I
          JOIN Boosters as B ON B.id = I.boosterId
          WHERE I.ownerId = '$idUser'";
  return parcoursRs(SQLSelect($sql));
}

function getBoosterInInv($invId) {
  $sql = "SELECT * FROM BoosterInventory WHERE id = '$invId'";
  return parcoursRs(SQLSelect($sql))[0];
}

function rmBoosterFromInv($invId) {
  $sql = "DELETE FROM BoosterInventory WHERE id = '$invId'";
  return SQLDelete($sql);
}
/* ----------- ! PUBLICATION ! ----------- */
// Liste les publications
function listerPublications(){
  $sql = "SELECT * FROM Publications";
  return parcoursRs(SQLSelect($sql));
}

// Récupère les informations d'une publication selon son id
function infoPublication($id){
  return parcoursRs(SQLSelect("
  SELECT name, description, idCreator, minia_path, poster_path, rarity
  FROM Publications
  WHERE id='$id';"));
}


// Créer une publication
function createPublication($name, $description, $idCreator, $minia_path, $poster_path, $rarity){
return SQLInsert("
INSERT INTO Publications(name, description, idCreator, minia_path, poster_path, rarity)
VALUES('$name', '$description', '$idCreator', '$minia_path', '$poster_path', '$rarity');");
}

// Supprime une publication
function deletePublication($id){
    return SQLDelete("
    DELETE FROM Publications
    WHERE id='$id';");
}

/* ----------- ! CARDS ! ----------- */

// Liste les cartes dans la BDD
function listerCards(){
  $sql = "
  SELECT id, name, description, idCreator, minia_path, poster_path, rarity
  FROM Cards";
return parcoursRs(SQLSelect($sql));
}

// Supprime une carte de la BDD
function supprimerCard($idCard){
  return SQLDelete("
  DELETE FROM Cards
  WHERE id='$idCard';");
}

// Supprimer les cartes dans la BDD
function supprimerCardInv($idCard)
{
  return SQLDelete("
  DELETE FROM Circulation
  WHERE cardId='$idCard';");
}

function supprimerCardMarket($idCard)
{
  return SQLDelete("
  DELETE FROM MarketOffers
  WHERE tradedCardId='$idCard' OR soldCardId='$idCard';");
}

function createCard($name, $description, $idCreator, $minia_path, $poster_path, $rarity){
  return SQLInsert("
  INSERT INTO Cards(name, description, idCreator, minia_path, poster_path, rarity)
  VALUES('$name', '$description', '$idCreator', '$minia_path', '$poster_path', '$rarity');");
}

function cardInfo($idCard){
  return parcoursRs(SQLSelect("
  SELECT * FROM Cards WHERE id='$idCard'
  "))[0];
}

function changeCardOwner($circuId, $newOwner) {
  $sql = "UPDATE Circulation SET ownerId='$newOwner' WHERE id='$circuId'";
  return SQLUpdate($sql);
}

function notInmarketAnymore($circuId) {
  $sql = "UPDATE Circulation SET inMarket=0 WHERE id='$circuId'";
  return SQLUpdate($sql);
}

function getCardsOfType($idCard, $idUser) {
  $sql = "SELECT id FROM Circulation WHERE ownerId='$idUser' AND cardId='$idCard'";
  return parcoursRs(SQLSelect($sql));
}

/* ----------- ! OPENING ! ----------- */
function getRandomCard($rarity="any") {
  if ($rarity == "any") {
    $sql = "SELECT id FROM Cards ORDER BY RAND() LIMIT 1";
  } else {
    $sql = "SELECT id FROM Cards WHERE rarity='$rarity' ORDER BY RAND() LIMIT 1"; 
  }
  return SQLGetChamp($sql);
}

function addCardToUser($idUser, $idCard) {
  $sql = "INSERT INTO Circulation (ownerId, cardId, inMarket) VALUES ('$idUser','$idCard',0)";
  return SQLInsert($sql);
}

/* ----------- ! QUESTIONS ! ----------- */
// Liste les questions
function listerQuestions()
{
  $sql = "
    SELECT id, name, content, answer, reward
    FROM Questions;
  ";
  return parcoursRs(SQLSelect($sql));
}

// Supprime une question
function supprimerQuestion($idQuestion)
{
    return SQLDelete("
    DELETE FROM Questions
    WHERE id='$idQuestion';");
}

// Créer une question
function créerQuestion($name, $content, $answer, $reward)
{
	return SQLInsert("
    INSERT INTO Questions(name, content, answer, reward)
    VALUES('$name', '$content', '$answer', '$reward');");
}

function getQuestionsUser($idUser) {
  $sql = "SELECT questionId FROM UserQuestions WHERE userId = '$idUser'";
  return parcoursRs(SQLSelect($sql));
}

function getInfoQuestion($idQuestion) {
  $sql = "
    SELECT id, name, content, answer, reward
    FROM Questions WHERE id='$idQuestion';
  ";
  return parcoursRs(SQLSelect($sql))[0];
}


/* ----------- ! MARKETPLACE ! ----------- */
function listerToutesLesOffresSaufUser($idUser)  // liste les offres qui ne sont pas faites par l'utilisateur en question
{
  $sql = "SELECT M.id AS id ,
                 M.isTrade AS trade,
                 M.soldCardId AS circuId,
                 M.cost AS cost,
                 M.tradedcardId AS tradedId,
                 C.cardId AS cardId
          FROM MarketOffers AS M 
          JOIN Circulation AS C
            ON M.soldCardId = C.id
          WHERE C.ownerId != '$idUser'";
  return parcoursRs(SQLSelect($sql));
}

function getOwnerFromOffer($idOffer) {
  $sql = "SELECT C.ownerId FROM Circulation AS C JOIN MarketOffers AS M ON C.id = M.soldCardId WHERE M.id='$idOffer'";
  return SQLGetChamp($sql);
}

function getInfoOffer($idOffer) {
  $sql = "SELECT * FROM MarketOffers WHERE id='$idOffer'";
  return parcoursRs(SQLSelect($sql))[0];
}

function removeOffer($idOffer) {
  $sql = "DELETE FROM MarketOffers WHERE id='$idOffer'";
  return SQLDelete($sql);
}

?>