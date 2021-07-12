<?php
session_start();
require_once('core/database.php');
if(isset($_GET['vkey'])){
    $query = "UPDATE users SET verify = 1 WHERE vkey = :vkey";
    $handler = $conn->prepare($query);
    $handler->bindParam(':vkey',$_GET['vkey']);
    if($handler->execute()){
        $_SESSION['verify'] = "Email Verify success. You may login in";
    }else{
        $_SESSION['verify'] = "Please to verify your email agian";
    }
    header('Location:login.php');  
}


?>