<?php
session_start();
require_once('vendor/autoload.php');

$FBObject = new \Facebook\Facebook([
	'app_id' => '164092712323793',
	'app_secret' => 'bb628f8aa03bd1cc551345affe778112',
	'default_graph_version' => 'v11.0'
]);

$handler = $FBObject -> getRedirectLoginHelper();


?>