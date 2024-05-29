<?php
session_start();

	include_once "libs/maLibUtils.php";
	include_once "libs/maLibSQL.pdo.php";
	include_once "libs/maLibSecurisation.php"; 
	include_once "libs/modele.php"; 
	include_once "libs/LibCardCollect.php"; 


	$qs = $_GET;

	if ($action = valider("action"))
	{
		ob_start ();
		echo "Action = '$action' <br />";
		// ATTENTION : le codage des caractères peut poser PB si on utilise des actions comportant des accents... 
		// A EVITER si on ne maitrise pas ce type de problématiques

		/* TODO: A REVOIR !!
		// Dans tous les cas, il faut etre logue... 
		// Sauf si on veut se connecter (action == Connexion)

		if ($action != "Connexion") 
			securiser("login");
		*/

		// Un paramètre action a été soumis, on fait le boulot...
		switch($action)
		{
			
			
			// Connexion //////////////////////////////////////////////////
			case 'Connexion' :
				// On verifie la presence des champs login et passe
				if ($login = valider("login"))
				if ($passe = valider("passe"))
				{
					// On verifie l'utilisateur, 
					// et on crée des variables de session si tout est OK
					// Cf. maLibSecurisation
					if (verifUser($login,$passe)) {
						// tout s'est bien passé, doit-on se souvenir de la personne ? 
						if (valider("remember")) {
							setcookie("login",$login , time()+60*60*24*30);
							setcookie("passe",$password, time()+60*60*24*30);
							setcookie("remember",true, time()+60*60*24*30);
						} else {
							setcookie("login","", time()-3600);
							setcookie("passe","", time()-3600);
							setcookie("remember",false, time()-3600);
						}
					}
					else {
						$qs["message"] = "Nom d'utilisateur ou mot de passe incorrect !";
					}
				}

				// On redirigera vers la page index automatiquement
			break;

			case 'Déconnexion' :
				// traitement métier
	      $_SESSION["pseudo"] = false;
	      $_SESSION["idUser"] = $false;
	      $_SESSION["connected"] = false;
	      $_SESSION["heureConnexion"] = false;
	      $_SESSION["permissions"] = false;
			break;

			case 'Inscription':
				if(($login = valider("login", "GET")) &&
				   ($passe = valider("passe", "GET")) &&
				   ($email = valider("email", "GET"))){
					if (usernameExists($login) != false) {
						$qs["message"] = "Le nom d'utilisateur existe déjà !";
						break;
					}
					if (emailExists($email) != false) {
						$qs["message"] = "Ce mail est déjà utilisé !";
						break;
					}
					createUser($login, $passe, $email);
					$id = getId($login);
					autoriserUtilisateur($id);
					$qs["message"] = "Inscription réussie ! Vous pouvez maintenant vous connecter.";
				}
			break;
      
      // Utilisateurs
			case 'Autoriser' :
				if ($idUser = valider("idUser"))  
				if (valider("connected","SESSION"))
				if (valider("permissions", "SESSION") == 2) 
				if (is_array($idUser)) {
					foreach($idUser as $nextIdUser) {
						autoriserUtilisateur($nextIdUser); 
					}
				} else {
					autoriserUtilisateur($idUser); 
				}
				$qs = "?view=administration"; 
			break;

			case 'Interdire' : 
				if ($idUser = valider("idUser"))  
				if (valider("connected","SESSION"))
				if (valider("permissions", "SESSION") == 2) 
				if (is_array($idUser)) {
					foreach($idUser as $nextIdUser) {
						interdireUtilisateur($nextIdUser); 
					}
				} else {
					interdireUtilisateur($idUser); 
				}
				$qs = "?view=administration"; 
			break; 

			case 'Promouvoir modérateur' :
				if ($idUser = valider("idUser"))  
				if (valider("connected","SESSION"))
				if (valider("permissions", "SESSION") == 2) 
				if (is_array($idUser)) {
					foreach($idUser as $nextIdUser) {
						promoModerateur($nextIdUser); 
					}
				} else {
					promoModerateur($idUser); 
				}
				$qs = "?view=administration"; 
			break;

			case 'Promouvoir administrateur' :
				if ($idUser = valider("idUser"))  
				if (valider("connected","SESSION"))
				if (valider("permissions", "SESSION") == 2) 
				if (is_array($idUser)) {
					foreach($idUser as $nextIdUser) {
						promoAdmin($nextIdUser); 
					}
				} else {
					promoAdmin($idUser); 
				}
				$qs = "?view=administration"; 
			break;

			case 'Rétrograder' :
				if ($idUser = valider("idUser"))  
				if (valider("connected","SESSION"))
				if (valider("permissions", "SESSION") == 2) 
				if (is_array($idUser)) {
					foreach($idUser as $nextIdUser) {
						retrograde($nextIdUser); 
					}
				} else {
					retrograde($idUser); 
				}
				$qs = "?view=administration"; 
			break;

			case 'Créer compte':
				if((valider("connected","SESSION")) &&
				(valider("permissions", "SESSION") == 2)  &&
				($login = valider("login", "GET")) &&
				($passe = valider("passe", "GET")) &&
				($email = valider("email", "GET"))){
				 if (usernameExists($login) != false) {
					 $qs["message"] = "Le nom d'utilisateur existe déjà !";
					 break;
				 }
				 if (emailExists($email) != false) {
					 $qs["message"] = "Ce mail est déjà utilisé !";
					 break;
				 }
				 createUser($login, $passe, $email);
				 autoriserUtilisateur(getId($login));
				}
				$qs = "?view=administration"; 
			break;



			case 'Supprimer question':
				if((valider("connected","SESSION")) &&
				(valider("permissions", "SESSION") == 2)  &&
				($idQuestion = valider("idQuestion", "GET"))){ 
					if (is_array($idQuestion)) {
						foreach($idQuestion as $nextIdQuestion) {
							supprimerQuestion($nextIdQuestion); 
						}
					} else {
						supprimerQuestion($idQuestion); 
					}
				}
				$qs = "?view=administration";
			break;

			case 'Créer question':
				if((valider("connected","SESSION")) &&
				(valider("permissions", "SESSION") == 2)  &&
				($name = valider("name", "GET")) &&
				($content = valider("content", "GET")) &&
				($answer = valider("answer", "GET")) &&
				($reward = valider("reward", "GET"))){
					créerQuestion($name, $content, $answer, $reward);
				}
				$qs = "?view=administration";
			break;


			case 'Ajouter shop':
			if((valider("connected","SESSION")) &&
			(valider("permissions", "SESSION") == 2)  &&
			($idBooster = valider("idBooster", "GET"))){
				if (is_array($idBooster)) {
					foreach($idBooster as $nextIdBooster) {
						ajouterShop($nextIdBooster);
					}
				}
				else {
					ajouterShop($idBooster);
				}
			}
			$qs = "?view=administration";
			break;

			case 'Retirer shop':
				if((valider("connected","SESSION")) &&
				(valider("permissions", "SESSION") == 2)  &&
				($idBooster = valider("idBooster", "GET"))){
					if (is_array($idBooster)) {
						foreach($idBooster as $nextIdBooster) {
							retirerShop($nextIdBooster);
						}
					}
					else {
						retirerShop($idBooster);
					}
				}
			$qs = "?view=administration";
			break;
			
			case 'Supprimer booster':
				if((valider("connected","SESSION")) &&
				(valider("permissions", "SESSION") == 2)  &&
				($idBooster = valider("idBooster", "GET"))){ 
					if (is_array($idBooster)) {
						foreach($idBooster as $nextIdBooster) {
							supprimerBoosterInv($nextIdBooster);
							supprimerBooster($nextIdBooster); 
						}
					} else {
						supprimerBoosterInv($idBooster);
						supprimerBooster($idBooster); 

					}
				}
				$qs = "?view=administration";
			break;

			case 'Créer booster':
				if((valider("connected","SESSION")) &&
				(valider("permissions", "SESSION") == 2) &&
				($name = valider("name", "GET")) &&
				(($cost = valider("cost", "GET")) != NULL) &&
				(($nbCommon = valider("nbCommon", "GET")) != NULL) &&
				(($nbUncommon = valider("nbUncommon", "GET")) != NULL) &&
				(($nbEpic = valider("nbEpic", "GET")) != NULL) &&
				(($nbLegendary = valider("nbLegendary", "GET")) != NULL) &&
				(($nbRandom = valider("nbRandom", "GET")) != NULL)){
					créerBooster($name, $cost, $nbCommon, $nbUncommon, $nbEpic, $nbLegendary, $nbRandom);
				}
				$qs = "?view=administration";
			break;

			case 'Acheter booster':
				if((valider("connected","SESSION")) &&
				   ($idBooster = valider("idBooster", "GET")) &&
				   ($cost = valider("cost", "GET")) &&
				   (getCoins(valider("idUser", "SESSION")) - $cost >= 0)){
						achat(valider("idUser", "SESSION"), $cost);
						giveBooster(valider("idUser", "SESSION"), $idBooster);
				   }
				else {
					$qs["message"] = "Pas assez de coins !";
				}
			break;
		}

	}

	// On redirige toujours vers la page index, mais on ne connait pas le répertoire de base
	// On l'extrait donc du chemin du script courant : $_SERVER["PHP_SELF"]
	// Par exemple, si $_SERVER["PHP_SELF"] vaut /chat/data.php, dirname($_SERVER["PHP_SELF"]) contient /chat

	$urlBase = dirname($_SERVER["PHP_SELF"]) . "/index.php";
	// On redirige vers la page index avec les bons arguments
	//header("Location:" . $urlBase . $qs);
	rediriger($urlBase, $qs);

	// On écrit seulement après cette entête
	ob_end_flush();
	
	
?>










