<?php
/*
Plugin Name: Telegram Notification
Plugin URI:
Description: Send link click notifications via Telegram
Version: 1.0
Author: Davide Ruggeri
Author URI:
*/

// No direct call
if( !defined( 'YOURLS_ABSPATH' ) ) die();
include 'Telegram.php';


function warning_open ( $args ) {
	$url = $args[0];
	$keyword = $args[1];
	$telegram = new Telegram(THUONGTIN_TELEGRAM_TOKEN);
	$msg = "Link cliccato";
	$msg .= "\nKeyword: " . $keyword;
	$msg .= "\nIP: " . $_SERVER['REMOTE_ADDR'];
	foreach ($GLOBALS["send_to"] as $destinatario)
	{
		$content = array('chat_id' => $destinatario, 'text' => $msg);
		$telegram->sendMessage($content);
	}
}

function prevent_cache($args)
{
	header("Cache-Control: no-cache, must-revalidate");
	$location = $args[0];
	$code = $args[1];
}

yourls_add_action( 'redirect_shorturl', 'warning_open' );
yourls_add_action('pre_redirect', 'prevent_cache');
