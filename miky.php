<?php

	


	class crud
	{ // CreateReadUpdateDelete
		private $host;
		private $user;
		private $password;
		public $database;
		public $table;
		private $pdo;

		function __construct($host, $user, $password, $database) {
			
			require_once "config.php";

			$this->host = DB_HOST; 
			$this->user = DB_USER; 
			$this->password = DB_PASSWORD; 
			$this->database = DB_NAME;

			$this->pdo = new PDO('mysql:host='.$this->host.';dbname='.$this->database,$this->user,$this->password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
		}

		/***************************crud function****************************************/

		public function select($champs = '*',  $table = '', $where = 1){
				$theChamp =$this->arrayToString($champs);
				$theWhere =$this->arrayToString($where);
			
			try{

				$result = $this->pdo->query("SELECT $theChamp FROM $table");
				return $result->fetchALL(PDO::FETCH_ASSOC);
			}catch(Exception $e) {
				echo 'merde'."\n";
			}
		}


		public function insert($champs , $valeur, $table){
				$theChamp = $this->arrayToString($champs);
				$theValue = $this->arrayToString($valeur,2);

				
			try{	
				$result = $this->pdo->prepare("INSERT INTO $table ($theChamp) VALUES($theValue)");

				$result->execute();

				return $this->pdo->lastInsertId();

			}catch(Exception $e){ //try catch permet de gerer les fatal error
				echo 'merde'."\n";
			}
		}


		public function delete($champs, $table){
				$theChamp = $this->arrayToString($champs, 3);
				
				try{
					$result = $this->pdo->prepare("DELETE FROM $table WHERE $theChamp");

					$result->execute();

				}catch(Exception $e){ //try catch permet de gerer les fatal error
					echo 'merde'."\n";
			}
		}


		public function update($champs,$where, $table){
				$theChamp = $this->arrayToString($champs, 3);
				$where = $this->arrayToString($where, 3);
				
				try{
					$result = $this->pdo->prepare("UPDATE $table SET $theChamp WHERE $where");
					$result->execute();
				}catch(Exception $e){ //try catch permet de gerer les fatal error
					echo 'merde'."\n";
				}
		}


			

		



		/************************************************/


		private function arrayToString($champs, $type = "select"){
			$theChamp="";
			// cas $champs est un tableau
			if(is_array($champs)){
					if($type == 1)
						foreach($champs as $value)
							$theChamp .= $theChamps ."'".$value .',';	 

					elseif($type == 3){
						foreach($champs as $key => $value)
							$theChamp = $theChamp.$key."='".$value."' AND ";
						$theChamp = substr($theChamp,0,-4);
					}elseif($type == 4)
						foreach($champs as $key => $value)
							$theChamp = $theChamp .$key ."=". $value ."',";
					else//type == 2
						foreach($champs as $value)
							$theChamp = $theChamp ."'". $value ."',";
				$theChamp = substr($theChamp,0,-1);
			}else
				$theChamp = $champs;

			return $theChamp;

		}
	}



		


// $bd = new crud("localhost","root","","mike-j");  //class instencié
// $bd->select(array("nom","prenom"), "users");
// $bd->insert(array("nom","prenom"),array("django","mike"), "users");
 // $bd->delete(array("nom" => "django", "prenom" => "mike"), "users");

