<?php

// activate full error reporting
//error_reporting(E_ALL & E_STRICT);



class Sendmessage 
{
	// $ci = & get_instance();
	// $ci->send();
	function send($email,$mes)
	{
		include_once 'XMPPHP/XMPP.php';
		$conn = new XMPPHP_XMPP('chat.quick.com', 5222, 'notifications', '123456', 'kaizenQuick', 'chat.quick.com', $printlog = false, $loglevel = XMPPHP_Log::LEVEL_INFO);

		try {
		  $conn->connect();
		  $conn->processUntil('session_start');
		  $conn->presence();

		  $conn->message($email, $mes);

		  $conn->disconnect();
		} catch (XMPPHP_Exception $e) {
		  die($e->getMessage());
		}
	}
}
