<?php
	ini_set('error_reporting', E_ALL);
	include 'util.php';
	include 'AbTelegramBot.php';

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
		case $message_text:
			$message_text = strrev($message_text);
			$telegramBot->sendMessages($chatID,$message_text);
			break;
		default:
			$telegramBot->sendMessages($chatID,ERR_MSG);
			break;
	}
	
?>