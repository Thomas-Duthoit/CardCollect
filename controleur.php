<?php
session_start();

	include_once "libs/maLibUtils.php";
	include_once "libs/maLibSQL.pdo.php";
	include_once "libs/maLibSecurisation.php"; 
	include_once "libs/modele.php"; 

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
					  $qs = array("message" => "Connexion réussie");
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
				}

				// On redirigera vers la page index automatiquement
			break;

			case 'Logout' :
				// traitement métier
	      $_SESSION["pseudo"] = false;
	      $_SESSION["idUser"] = $false;
	      $_SESSION["connecte"] = false;
	      $_SESSION["heureConnexion"] = false;
	      $_SESSION["isAdmin"] = false;
	      $qs = array("view" => "login",
	                  "message" => "Déconnexion réussie");
			break;
      
      // Conversations
			case 'Archiver' :
			  // Remarque : mon erreur en séance était d'écrire :
			  //   valider("admin", "SESSION")
			  // au lieu de :
			  //   valider("isAdmin", "SESSION")
			  if (($idConversation = valider("idConv", "GET"))
			      && valider("isAdmin", "SESSION")) {
			    archiverConversation($idConversation);
			  }
			break;

			case 'Reactiver' :
			  if (($idConversation = valider("idConv", "GET"))
			      && valider("isAdmin", "SESSION")) {
			    reactiverConversation($idConversation);
			  }
			break;
			
			case 'Supprimer' :
			  if (($idConversation = valider("idConv", "GET"))
			      && valider("isAdmin", "SESSION")) {
			    supprimerConversation($idConversation);
			  }
			break;

			case 'Creer conversation' :
			  if (($theme = valider("theme", "GET"))
			      && valider("isAdmin", "SESSION")) {
			    $idConv = creerConversation($theme);
			    $qs["idConv"] = $idConv;
			  }
			break;
      
      // Utilisateurs
			case 'Autoriser' : 
			break;

			case 'Interdire' :  
			break; 

      // Messages
			case 'Poster' :
			  if (($contenu = valider("contenu", "GET"))
			      && ($idConv = valider("idConv", "GET"))
			      && ($idUser = valider("idUser", "SESSION"))
			      && ($conv = getConversation($idConv))
			      && (!empty($conv))
			      && ($conv[0]["active"])) {
	        enregistrerMessage($idConv, $idUser, $contenu);
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










