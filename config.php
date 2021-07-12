<?php
    require_once("vendor/autoload.php");
    $google_client = new Google_Client();
    $google_client->setClientId("1040143659428-avjd8m48jam05jok71h1kf25vevm6vbo.apps.googleusercontent.com");
    $google_client->setClientSecret("Ruw67Y1qQFFNlj8xkYHn2nRZ");
    $google_client->setRedirectUri("http://localhost/TasksPHP/core/auth.php");
    $google_client->addScope('profile');
    $google_client->addScope('email');

    $glogin = $google_client->createAuthUrl();
?>