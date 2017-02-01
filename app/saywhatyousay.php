<?php
	session_start();
	session_destroy();
	ini_set('error_reporting', 0);
	include 'utils/DateTimeUtil.php';
	include 'utils/constant.php';

	include 'AbTelegramBot.php';



	/*
	* TELEGRAM BOT SETUP
	*/
	$token = "260823376:AAFILe7j6XD6efwhmkgC1xWcUDazanSZd3c";
	$telegramBot = new AbTelegramBot($token);

	$response = file_get_contents('php://input');
	$update = json_decode($response, true);

	$message = $update[MSG];         // Message-Array
	$chatID = $message[CHAT][ID];     // Chat ID
	$message_text = $message[TEXT];     // Message Text


	/*
	* TELEGRAM BOT ACTION
	*/
	$splitCommand = explode(" ",$message_text);
	$filter = false;
	if(count($splitCommand)==2){
		$filter = true;
	}
	if(!$filter){
		switch ($message_text) {
			case '/who':
				$instagramAccount = "https://www.instagram.com/abdymalikmulky/";
				$telegramBot->sendMessages($chatID,$instagramAccount);
				break;
			case '/jadwal':
				include 'JadwalBola.php';

				$jadwalBola = new JadwalBola();
				$dataJadwal = $jadwalBola->getJadwal();
				$total = $dataJadwal['total'];
				$kickOff = $dataJadwal['kickoff'];



				$starterMessage = $total. " Match Minggu Ini ⚽️";
				$telegramBot->sendMessages($chatID,$starterMessage);

				foreach ($kickOff as $key => $value) {
					$message = tidyUp($value);
					$telegramBot->sendMessages($chatID,$message);
				}
				break;
			case $message_text:
				$message_text = strrev($message_text);
				$telegramBot->sendMessages($chatID,$message_text);
				break;
			default:
				$telegramBot->sendMessages($chatID,ERR_MSG);
				break;
		}
	}else{
		switch ($splitCommand[0]) {
			case '/jadwal':
				include 'JadwalBola.php';

				$limit = $splitCommand[1];

				$jadwalBola = new JadwalBola();
				$dataJadwal = $jadwalBola->getJadwal($limit);
				$total = $dataJadwal['total'];
				$kickOff = $dataJadwal['kickoff'];

				$starterMessage = $limit." dari ".$total. " Match Minggu Ini ⚽️";
				$telegramBot->sendMessages($chatID,$starterMessage);

				foreach ($kickOff as $key => $value) {
					$message = tidyUp($value);
					$telegramBot->sendMessages($chatID,$message);
				}
				break;
			default:
				$telegramBot->sendMessages($chatID,ERR_MSG);
				break;
		}
	}


	function tidyUp($value){
		$date = DateTimeUtil::convertToIndDate($value['date']);
		$time = $value['time'];
		$match = $value['match'];
		$matchHome = $match['home'];
		$matchAway = $match['away'];
		$event = $value['event'];
		$tv = $value['tv'];
		$matchString = $matchHome." VS ".$matchAway;

		$jadwalMessage .= $matchString;
		$jadwalMessage .= "\n🕐 ".$date." ".$time;
		$jadwalMessage .= "\n⚽️ ".$event;
		$jadwalMessage .= "\n📺 ".$tv;

		return $jadwalMessage;
	}
?>
