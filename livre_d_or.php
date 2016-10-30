<?php

//Insertion de la classe signataire
require_once('modele/signataire.php');
require_once('modele/database.php');
//Vérification de la présence du paramètre "add"
if(htmlspecialchars(isset($_GET['add']))){
	//Présence du paramètre "add", donc appel du formulaire
	require_once('vue/formulaire.php');
}
else{
	// On vérifie que les données sont bien reçues;
	if (isset($_REQUEST['civilite'])
		&& isset($_REQUEST['nom_complet'])
		&& isset($_REQUEST['email'])
		&& isset($_REQUEST['pseudo'])
		&& isset($_REQUEST['anonymat'])
		&& isset($_REQUEST['message'])
		&& isset($_REQUEST['relation'])) {

		/** htmlspecialchars
		* Je le garde pour plus tard...
		* $message = nl2br($message);
		* $_REQUEST['message']=$message;
		* $_REQUEST = mysql_real_escape_string($_REQUEST); //ça ne marche pas...
		**/

		//Instanciation de l'objet Signataire avec les données reçues
		$perso = new Signataire($_REQUEST);

		// On récupère le chemin du fichier
		$source = $_FILES['photo']['tmp_name'];
		// On spécifie la destination du fichier
		$destination='medias/'.$_FILES['photo']['name'];

		//ensuite on déplace le fichier de la source vers la destination
		$resultat = move_uploaded_file($source,$destination);

		//Si le fichier a été bien chargé alors resultat contiendra true
		if($resultat){	//si c'est le cas, alors :
			//On met le chemin du fichier dans la propiété photo de la classe Signataire
			$perso->setPhoto($destination);
		}

		//et on ajoute les données à la base
		$perso->ajouter();

		//enfin on fait une rédirection vers livre_d_or.php pour afficher les signatures.
		header('Location: livre_d_or.php');
	}
	else{ //Si aucune données n'a été transmise, alors :
		//on vérifie si le paramètre page existe.
		if(isset($_GET['page'])){
			$page = $_GET['page']; //on récupère le numero de la page à afficher.
		}
		else{//Sinon, ça voudra dire que l'utilisateur vient d'arriver sur la page et
		//donc on affcihe la page 1.
			$page = 1;
		}
		//On définit le nombre de signatures par page;
		$nbre_sign_par_page = 3;

		//Ensuite on récupère le nombre de signature dans la base de données.
		$nbre_total_signature = 0;
		$req = DataBase::getInstance()->prepare('SELECT COUNT(*) AS nbre FROM signataire');

		//On récupère le retour de la requête
		$data = $req->fetch(PDO::FETCH_ASSOC);
		$nbre_total_signature = $data['nbre'];

		//et ensuite on calcul le nbre de page nécessaire pour afficher les signatures.
		$nbre_de_page = ceil($nbre_total_signature/$nbre_sign_par_page);

		//pour finir on calcul le numero de la première signature à afficher.
		$num_premiere_signature = ($page - 1) * $nbre_sign_par_page;

		//on fait appel à la méthode lister de la classe pour récupérer les données de la base.
		$list = Signataire::lister($num_premiere_signature,$nbre_sign_par_page);
		//et on inclu la vue livre_dor.html pour afficher les signatures.
		require_once('vue/livre_dor.html');

		}
}

?>
