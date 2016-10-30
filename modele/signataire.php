<?php
//insertion de la classe DataBase pour la connexion
	require_once('database.php');
	//La classe représentant les signataires
	class Signataire{
		//private $id_sign=0;
		private $civilite = 'Mme';
		private $nom_complet = '';
		private $email = '';
		private $pseudo = '';
		private $anonymat ='';
		private $message = '';
		private $relation = array();
		private $photo = '';

		function __construct($signa){
			if(is_array($signa)){
				foreach ($signa as $k => $v) {
					if(property_exists($this, $k)){
						if($k == 'relation'){
							if(!is_array($v))
								$v = explode(';', $v);
						}
						$this->$k = $v;
					}
				}
			}
		}//	FIN du Constructeur

		//Les getteurs pour les attributs
		public function civilite(){	return $this->civilite;	}

		public function nom_complet(){ return $this->nom_complet; }

		public function email(){ return $this->email; }

		public function pseudo(){ return $this->pseudo; }

		public function anonymat(){ return $this->anonymat; }

		public function message(){ return $this->message; }

		public function relation(){ return $this->relation; }

		public function photo(){ return $this->photo; }

		// Un setteur pour la photo
		public function setPhoto($photo){ $this->photo=$photo; }

		//La fonction permettant d'ajouter une signature
		public function ajouter(){

			//Préparation des données
			$donnees = array(
				':civilite'=>$this->civilite,
				':nom_complet'=>$this->nom_complet,
				':email'=>$this->email,
				':pseudo'=>$this->pseudo,
				':anonymat'=>$this->anonymat,
				':message'=>$this->message,
				':relation'=>implode(';', $this->relation),
				':photo'=>$this->photo
				);

			//Exécution de la requête avec les données préparées
			DataBase::getInstance()->prepare('INSERT INTO signataire(civilite,nom_complet,email,pseudo,anonymat,message,relation,photo)
									  VALUES(:civilite,:nom_complet,:email,:pseudo,:anonymat,:message,:relation,:photo)',$donnees);

		}

		//la fonction permettant de récupérer la liste des signatures
		public static function lister($num, $nbre){

			//Exécution de la réquête
			$requete = DataBase::getInstance()->prepare('SELECT * FROM signataire
				ORDER BY id_sign DESC LIMIT '.$num.','.$nbre);

			//Tableau de type signataire pour stockés le resultat de la requete
			$list = array();
			while ($sign = $requete->fetch(PDO::FETCH_ASSOC)) {
				$list[] = new Signataire($sign);
			}

			//Enfin on retourne le tableau list
			return $list;
		}

	}//FIN de la Class
?>
