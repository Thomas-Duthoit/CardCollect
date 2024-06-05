<?php
session_start();

	include_once "libs/maLibUtils.php";
	include_once "libs/maLibSQL.pdo.php";
	include_once "libs/maLibSecurisation.php"; 
	include_once "libs/modele.php"; 
	include_once "libs/LibCardCollect.php"; 


	$qs = $_GET;
	$redirect = FALSE;

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
					if(isAllowed($login))
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
				$redirect = TRUE;
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
				$redirect = TRUE;
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
				$redirect = TRUE;
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
				$redirect = TRUE;
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
				$redirect = TRUE;
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
				$redirect = TRUE;
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
				$redirect = TRUE;
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
				$redirect = TRUE;
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
			$redirect = TRUE;
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
			$redirect = TRUE;
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
				$redirect = TRUE;
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
				$redirect = TRUE;
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

			case 'Supprimer carte':
				if((valider("connected","SESSION")) &&
				(valider("permissions", "SESSION") == 2)  &&
				($idCard = valider("idCard", "GET"))){ 
					if (is_array($idCard)) {
						foreach($idCard as $nextIdCard) {
							supprimerCardMarket($nextIdCard);
							supprimerCardInv($nextIdCard);
							supprimerCard($nextIdCard);
						}
					} else {
						supprimerCardMarket($idCard);
						supprimerCardInv($idCard);
						supprimerCard($idCard); 
					}
				}
				$qs = "?view=administration";
				$redirect = TRUE;
			break;
	
			case 'Créer carte':
				$target_dir = "img/";
				if((valider("connected","SESSION")) &&				// TOUTES LES CONDITIONS POUR LA CREATION DE CARTE
				(valider("permissions", "SESSION") == 2)  &&
				($name = valider("name", "POST")) &&
				($description = valider("description", "POST")) &&
				($idCreator = valider("idUser", "SESSION"))){
					if ($_POST["rarity"] == "0") {$rarity = 0;}
					else {$rarity = valider("rarity", "POST");}

						$target_file_minia = $target_dir . basename($_FILES["minia"]["name"]);
						$target_file_poster = $target_dir . basename($_FILES["poster"]["name"]);
						$fileType_minia = strtolower(pathinfo($target_file_minia,PATHINFO_EXTENSION));
						$fileType_poster = strtolower(pathinfo($target_file_poster,PATHINFO_EXTENSION));
						$_FILES["minia"]["name"] = date("ymdHis") . "_" . $name . "_minia" . "." . $fileType_minia;
						$_FILES["poster"]["name"] = date("ymdHis") . "_" . $name . "_poster" . "." . $fileType_poster;

						if(($fileType_minia == "jpg" || $fileType_minia == "png" || $fileType_minia == "jpeg") &&		// VERIFICATION DU FORMAT
						   ($fileType_poster == "jpg" || $fileType_poster == "png" || $fileType_poster == "jpeg")){
								tprint($_FILES);
								if(($minia_info = getimagesize($_FILES["minia"]["tmp_name"])) &&
								($poster_info = getimagesize($_FILES["poster"]["tmp_name"])))
								{
									if(($minia_info[0] == 300) && ($minia_info[1] == 300) &&					// VERIFICATION DES DIMENSIONS
									($poster_info[0] <= 3840) && ($poster_info[1] <= 2160)) {
										if((move_uploaded_file($_FILES["minia"]["tmp_name"], $target_dir . $_FILES["minia"]["name"])) &&
										(move_uploaded_file($_FILES["poster"]["tmp_name"], $target_dir . $_FILES["poster"]["name"])))
											createCard($name, $description, $idCreator, $_FILES["minia"]["name"], $_FILES["poster"]["name"], $rarity);		
									}
								}
						}

				}
				$qs = "?view=administration";
				$redirect = TRUE;
			break;

			case 'Publier':
				$target_dir = "img/";
				if((valider("connected","SESSION")) &&				// TOUTES LES CONDITIONS POUR LA CREATION DE CARTE
				($name = valider("name", "POST")) &&
				($description = valider("description", "POST")) &&
				($idCreator = valider("idUser", "SESSION"))){
					if ($_POST["rarity"] == "0") {$rarity = 0;}
					else {$rarity = valider("rarity", "POST");}

						$target_file_minia = $target_dir . basename($_FILES["minia"]["name"]);
						$target_file_poster = $target_dir . basename($_FILES["poster"]["name"]);
						$fileType_minia = strtolower(pathinfo($target_file_minia,PATHINFO_EXTENSION));
						$fileType_poster = strtolower(pathinfo($target_file_poster,PATHINFO_EXTENSION));
						$_FILES["minia"]["name"] = date("ymdHis") . "_" . $name . "_minia" . "." . $fileType_minia;
						$_FILES["poster"]["name"] = date("ymdHis") . "_" . $name . "_poster" . "." . $fileType_poster;

						if(($fileType_minia == "jpg" || $fileType_minia == "png" || $fileType_minia == "jpeg") &&		// VERIFICATION DU FORMAT
						   ($fileType_poster == "jpg" || $fileType_poster == "png" || $fileType_poster == "jpeg")){
								$minia_info = getimagesize($_FILES["minia"]["tmp_name"]);
								$poster_info = getimagesize($_FILES["poster"]["tmp_name"]);

								if(($minia_info[0] == 300) && ($minia_info[1] == 300) &&					// VERIFICATION DES DIMENSIONS
								($poster_info[0] <= 3840) && ($poster_info[1] <= 2160)) {
									if((move_uploaded_file($_FILES["minia"]["tmp_name"], $target_dir . $_FILES["minia"]["name"])) &&
									(move_uploaded_file($_FILES["poster"]["tmp_name"], $target_dir . $_FILES["poster"]["name"])))
										createPublication($name, $description, $idCreator, $_FILES["minia"]["name"], $_FILES["poster"]["name"], $rarity);
							}
						}

				}
			break;

			case 'AccepterPublication':
				if((valider("connected","SESSION")) &&				// TOUTES LES CONDITIONS POUR LA CREATION DE CARTE
				($idPublication = valider("idPublication", "GET")) &&
				(valider("permissions", "SESSION") >= 1)){
					$publication = infoPublication($idPublication);
					createCard($publication[0]["name"], $publication[0]["description"], $publication[0]["idCreator"], $publication[0]["minia_path"], $publication[0]["poster_path"], $publication[0]["rarity"]);
					deletePublication($idPublication);
				}
				$qs = "?view=moderation";
				$redirect = TRUE;
			break;
			
			case 'RefuserPublication':
				if((valider("connected","SESSION")) &&				// TOUTES LES CONDITIONS POUR LA CREATION DE CARTE
				($idPublication = valider("idPublication", "GET")) &&
				(valider("permissions", "SESSION") >= 1)){
					deletePublication($idPublication);
				}
				$qs = "?view=moderation";
				$redirect = TRUE;
			break;

			case 'OuvrirBooster':
				if (valider("connected", "SESSION"))
				if ($idUser = valider("idUser", "SESSION"))
				if ($idBooster = valider("idBooster", "GET")) {
					$boosterInfo = getBoosterInInv($idBooster);
					if ($boosterInfo["ownerId"] == $idUser) {
						echo "ouverture du booster: $idBooster :";
						tprint($boosterInfo);
						echo "Retrait de la BDD <br />";
						rmBoosterFromInv($idBooster);
						echo "Type de booster à ouvrir: " . $boosterInfo["boosterId"] . "<br />";
						$toOpen = infoBooster($boosterInfo["boosterId"])[0];
						$cards = array();
						tprint($toOpen);
						echo "<hr />";
						echo "cartes communes obtenues: <br/>";
						for ($i=0; $i<$toOpen["nbCommon"]; $i++) {
							$looted = getRandomCard(0);
							$cards[] = $looted;
							echo $looted . "<br />";
						}
						echo "cartes non-communes obtenues: <br/>";
						for ($i=0; $i<$toOpen["nbUncommon"]; $i++) {
							$looted = getRandomCard(1);
							$cards[] = $looted;
							echo $looted . "<br />";
						}
						echo "cartes épiques obtenues: <br/>";
						for ($i=0; $i<$toOpen["nbEpic"]; $i++) {
							$looted = getRandomCard(2);
							$cards[] = $looted;
							echo $looted . "<br />";
						}
						echo "cartes légendaires obtenues: <br/>";
						for ($i=0; $i<$toOpen["nbLegendary"]; $i++) {
							$looted = getRandomCard(3);
							$cards[] = $looted;
							echo $looted . "<br />";
						}
						echo "cartes random obtenues: <br/>";
						for ($i=0; $i<$toOpen["nbRandom"]; $i++) {
							$looted = getRandomCard();
							$cards[] = $looted;
							echo $looted . "<br />";
						}
						echo "Récapitulatif:";
						tprint($cards);

						$qs = "?view=opening";
						$redirect = TRUE;
						foreach ($cards as $c) {
							addCardToUser($idUser, $c);
							$qs =  $qs . "&cards[]=$c";
						}

					}
				}
				
			break;

			case 'Repondre':
				if (valider("connected", "SESSION"))
				if ($idUser = valider("idUser", "SESSION"))
				if ($idQuestion = valider("questionId", "GET"))
				if ($userAnswer = valider("answer", "GET")) {
					$q = getInfoQuestion($idQuestion);
					if ($q["answer"] == $userAnswer) {
						addCoinsToUser($idUser, $q["reward"]);
						// TODO: ajouter l'association user question et c'est tout bon
					}
				}
				$qs = "?view=questions";
				$redirect = TRUE;
			break;
		}

	}

	// On redirige toujours vers la page index, mais on ne connait pas le répertoire de base
	// On l'extrait donc du chemin du script courant : $_SERVER["PHP_SELF"]
	// Par exemple, si $_SERVER["PHP_SELF"] vaut /chat/data.php, dirname($_SERVER["PHP_SELF"]) contient /chat

	$urlBase = dirname($_SERVER["PHP_SELF"]) . "/index.php";
	// On redirige vers la page index avec les bons arguments
	if ($redirect) {
		header("Location:" . $urlBase . $qs);
	} else {
		rediriger($urlBase, $qs);
	}
	// On écrit seulement après cette entête
	ob_end_flush();
	
	
?>










