<?php
require_once __DIR__ . '/vendor/autoload.php';
//require_once("callback.php");
$fb = new \Facebook\Facebook([
  'app_id' => '{521689182366094}',
  'app_secret' => '{58233cca83a54bce85f3f3eb861ea07a}',
  'default_graph_version' => 'v11.0',
  'default_access_token' => '{access-token}', // optional
]);
$helper=$fb->getRedirectLoginHelper();
$login_url=$helper->getLoginUrl("http://localhost:8080/TasksPHP/config.php");
try {
    $accessToken = $helper->getAccessToken();
	if(isset($accessToken)){
		echo("Hello");
		$_SESSION['access_token']=(string) $accessToken;
		header('Location: display.php');
	};
}catch(Exception $e){
    echo $e->getTraceAsString();
}
if(isset($_SESSION['access_token'])){
	try{
		echo("Hello");
		$fb->setDefaultAccessToken($_SESSION['access_token']);
		$res=$fb->get('/me');
		$user=$res->getGraphUser();
		$me = $res->getGraphUser();
		echo($res);
		echo 'Logged in as ' . $me->getName();
		echo($user);
	}catch(Exception $e){
		echo $e->getTraceAsString();
		echo("something wrong");
	}
}