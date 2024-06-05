<?php
// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
	header("Location:../index.php?view=opening");
	die("");
}
// Si l'utilisateur n'a pas les permissions ou n'est pas connecté, on le redirige sur la page d'accueil
if (!valider("connected", "SESSION")) {
	rediriger("index.php?view=accueil&");
	die("");
}

$idUser = valider("idUser", "SESSION");

$qlist = listerQuestions();
// tprint($qlist);
$qdone = getQuestionsUser($idUser);
// tprint($qdone);
foreach ($qlist as $q) {
	$isAlreadyDone = FALSE;
	foreach ($qdone as $qinfo) {
		if ($qinfo["questionId"] == $q["id"]) $isAlreadyDone = TRUE;
	}
    mkQuestion($q, $isAlreadyDone);
}

?>