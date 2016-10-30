<?php
//insertion de la classe DataBase pour la connexion
	require_once('database.php');
	/*
		Définition de la classe relation pour gérer les valeurs
		du champ relation dans le formulaire.
	*/
	class Relation
	{
		private $nom_relation = '';

		function __construct($choi = null){
			if(is_array($choi)){
				foreach ($choi as $key => $value) {
					if(property_exists($this, $key)){
						$this->$key = $value;
					}
				}
			}
		}

		public function nom_relation(){
			return $this->nom_relation;
		}

		//La fonction permettant de récupérer les relations
		static public function liste_choix(){

			//Requête pour récupérer les relations
			$requete = DataBase::getInstance()->prepare('SELECT nom_relation FROM relation');
			$requete->execute();

			$choix = array();
				while ($relation = $requete->fetch(PDO::FETCH_ASSOC)) {
					$choix[] = new Relation($relation);
				}

				//On libère la connexion
				$pdo = null;

				//Enfin on retourne le tableau choix
				return $choix;
		}
	}//FIN DE LA CLASS RELATION
?>
