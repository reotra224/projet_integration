<?php
	//La classe qui gère l'accès à la base de données
	class DataBase{

		private $_pdo = null;
		private static $_instance = null;

		// Les paramètres de la connexion
		const SQL_HOST = 'localhost';
		const SQL_DB = 'integration';
		const SQL_USER = 'root';
		const SQL_PASS = '';

		public function __construct(){
			$this->_pdo = new PDO('mysql:host='.self::SQL_HOST.
														';dbname='.self::SQL_DB,
														self::SQL_USER,
														self::SQL_PASS);
		}

		public static function getInstance(){

			if(is_null(self::$_instance)){

				self::$_instance = new DataBase();

			}
			return self::$_instance;
		}

		public function prepare($query, $data=null){
			if(is_null($data)){
				$req = $this->_pdo->prepare($query);
				$req->execute();
				return $req;
			}
			else{
				if(is_array($data))
					$this->_pdo->prepare($query)->execute($data);
			}
		}

		/*
		public function PDO(){
			return $this->_pdo;
		}


		public function query($query){
			return $this->_pdo->query($query);
		}
		*/

	}//FIN DE LA CLASS DataBase
?>
