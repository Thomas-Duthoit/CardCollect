<?php

include_once "maLibSQL.pdo.php";

/* ----------- ! USERS ! ----------- */

function verifUserBdd($login, $passe)
{
  return SQLGetChamp("
    SELECT id
    FROM Users
    WHERE pseudo='$login'
      AND pass='$passe';
  ");
}

function getPermission($id){
    return SQLGetChamp("
        SELECT privileges
        FROM Users
        WHERE id='$id';
    ");
}

function usernameExists($login){
    return SQLGetChamp("
        SELECT id
        FROM Users
        WHERE pseudo='$login';");
}

function emailExists($email){
    return SQLGetChamp("
        SELECT id
        FROM Users
        WHERE mail='$email';");
}

function createUser($login, $passe, $mail){
    return SQLInsert("
        INSERT INTO Users(mail, pseudo, pass)
        VALUES('$mail', '$login', '$passe');");
}

function getId($login){
    return SQLGetChamp("
    SELECT id
    FROM Users
    WHERE pseudo='$login';");
}

function createVerif($id, $code){
    return SQLInsert("
        INSERT INTO Verification(idUser, code)
        VALUES('$id', '$code');");
}

?>