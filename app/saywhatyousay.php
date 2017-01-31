<?php
	session_start();

	ini_set('error_reporting', E_ALL);
	include 'util.php';
	include 'AbTelegramBot.php';

	if(!isset($_SESSION['kickoff'])){
		include 'JadwalBola.php';
		$jadwalBola = new JadwalBola();
		$dataJadwal = $jadwalBola->getJadwal();
		$kickOffJadwal = $dataJadwal['kickoff'];
		$_SESSION['kickoff']=$kickOffJadwal;
	}
	$kickOff = $_SESSION['kickoff'];

	//setToken
	$token = "260823376:AAFILe7j6XD6efwhmkgC1xWcUDazanSZd3c";
	$telegramBot = new AbTelegramBot($token);


	$response = file_get_contents('php://input');
	$update = json_decode($response, true);

	$message = $update[MSG];         // Message-Array
	$chatID = $message[CHAT][ID];     // Chat ID
	$message_text = $message[TEXT];     // Message Text

	switch ($message_text) {
		case '/who':
			$instagramAccount = "https://www.instagram.com/abdymalikmulky/";
			$telegramBot->sendMessages($chatID,$instagramAccount);
			break;
		case '/jadwal':
			$message = tidyUp($kickOff);
			$telegramBot->sendMessages($chatID,$message);
			break;
		case $message_text:
			$message_text = strrev($message_text);
			$telegramBot->sendMessages($chatID,$message_text);
			break;
		default:
			$telegramBot->sendMessages($chatID,ERR_MSG);
			break;
	}

	function tidyUp($kickOff){
		$jadwalMessage = "JADWAL MATCH\n";

		foreach ($kickOff as $key => $value) {
			$date = $value['date'];
			$day = $value['day'];
			$time = $value['time'];
			$match = $value['match'];
			$matchHome = $match['home'];
			$matchAway = $match['away'];
			$event = $value['event'];
			$tv = $value['tv'];
			$matchString = $matchHome." VS ".$matchAway;

			$jadwalMessage .= $matchString;
			$jadwalMessage .= "\n🕐 ".$day.", ".$date." ".$time;
			$jadwalMessage .= "\n⚽️ ".$event;
			$jadwalMessage .= "\n📺 ".$tv;
			$jadwalMessage .= "\n===================\n";
		}
		return $jadwalMessage;
	}
?>
