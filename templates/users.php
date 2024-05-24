<?php
// Ce fichier permet de tester les fonctions développées dans le fichier bdd.php (première partie)

// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
if (basename($_SERVER["PHP_SELF"]) == "users.php")
{
	header("Location:../index.php?view=users");
	die("");
}

include_once("libs/modele.php");
include_once("libs/maLibUtils.php"); // tprint
include_once("libs/maLibForms.php"); 
// définit mkTable
?>
<h1>Administration du site</h1>
<h2>Liste des utilisateurs de la base </h2>
<?php
echo "liste des utilisateurs autorises de la base :"; 
$users = listerUtilisateurs("nbl");
//tprint($users);	// préférer un appel à 
mkTable($users,array("id","pseudo"));

echo "<hr />";
echo "liste des utilisateurs non autorises de la base :"; 
$users = listerUtilisateurs("bl");
//tprint($users);	// préférer un appel à mkTable($users);
mkTable($users,array("id","pseudo"));
?>
<hr />
<h2>Changement de statut des utilisateurs</h2>

<form action="controleur.php">

<select name="idUser">
<?php
$users = listerUtilisateurs();

// préférer un appel à mkSelect("idUser",$users, ...)

//for($i=0;$i<count($users);$i++)
foreach ($users as $dataUser)
{
	//$dataUser = $users[$i];

	echo "<option value=\"$dataUser[id]\">\n";
	echo  $dataUser["pseudo"];	
	if ($dataUser["blacklist"] == 1) 	echo " (bl)"; 	
	else echo " (nbl)";
	echo "\n</option>\n"; 
}
?>
</select>

<input type="submit" name="action" value="Interdire" />
<input type="submit" name="action" value="Autoriser" />
</form>






