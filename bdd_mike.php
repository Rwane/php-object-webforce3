<?php

class users{//createreadupdatedelete

	/*
		variable global

	*/
		private $bd;

		function __construct(){
			$this->bd = new crud("localhost","root","myshop");

		}

		

		public function addUser($user = array()){
			if(!isset($user['firstname'])){
					return 0;
			}
			elseif(!isset($user['lastname'])){
					return 0;
			}
			elseif(!isset($user['password'])){
					return 0;
			}
			elseif(!isset($user['password'])){
					return 0;
			}
			$user['password'] = password_hash($user['password'], PASSWORD_DEFAULT); //cryptage mdp. 

			$this->bd->insert(array("firstname","lastname","email","password"), array("Johnny","mike"), "users");

		}

}