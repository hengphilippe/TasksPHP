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

if(isset($_POST['add'])){
	$title = $_POST['title'];
	$due_date = $_POST['due-date'];
	$category = $_POST['cat_id'];

print_r($title);
print_r($due_date);
print_r($category);	
$statement = "INSERT INTO tasks (title, due_date, cat_id, user_created) VALUES (:title, :due_date, :cat_id, $user_id)";
$handler = $conn->prepare($statement);

$handler->bindParam(":title", $title);
$handler->bindParam(":due_date", $due_date);
$handler->bindParam(":cat_id", $category);

if($handler->execute()){
	header("Location: ../app/tasks.php?category=".$category);
}
else {
	echo "Error! something wrong";
}
}