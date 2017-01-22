<?php
	/**
	 *
	 * adahuys1 . abdymalikmulky
	 * January 22 2017
	 *
	 */
	
	class AbTelegramBot{
		
		public $apis;

		public function __construct($token){
			$this->apis = URLAPI."".$token;
		}
		public function setToken($token){
			$this->apis = URLAPI."".$token;
		}
		public function getMe(){
			$method = "/getMe";
			$urlApi = $this->apis.$method;
			return $urlApi;
		}
		public function getUpdates(){
			$method = "/getUpdates";
			$urlApi = $this->apis.$method;
			return $urlApi;
		}
		public function sendMessages($chatId,$text){
			$method = "/sendMessage?chat_id=".$chatId."&text=".urlencode($text);
			$urlApi = $this->apis.$method;
			file_get_contents($urlApi);
		}
	}


?>