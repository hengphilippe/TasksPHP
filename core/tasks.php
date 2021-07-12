<?php

session_start();
require_once('../core/database.php');

if(!isset($_SESSION['user'])) {
	// response error to login while invalid user
	// 1. redirect to login page with message error
	// 2. display message error to screen
    $_SESSION['error'] = "Error 401! Unauthorize access.";
    header("Location: ../login.php");
}
// get user auth id
$user_id =  $_SESSION['user']['id'];


    if(isset($_POST["add"])) {
    $title =    $_POST["title"];
    $due_date = $_POST["due-date"];
    $cat_id = $_POST["cat_id"];
    if (empty($title)) {
        echo "Please enter title";
    }
    $statment = "INSERT INTO tasks (title,due_date,cat_id,user_created) VALUES(:title,:due_date,:cat_id,$user_id)";
    
        $handler = $conn->prepare($statment);
		$handler->bindParam(":title",$title);
		$handler->bindParam(":due_date",$due_date);
		$handler->bindParam(":cat_id", $cat_id);
        $handler->execute();

        
}

?>