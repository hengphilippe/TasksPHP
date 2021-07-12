<?php 
session_start();
require_once('database.php');

if(isset($_POST['title'])&&isset($_POST['cat_id'])&&isset($_POST['due_date'])){
    $insert = "INSERT INTO tasks (title,due_date,location,cat_id,user_created) VALUE (:title,:due_date,:location,:cat_id,:user_created)";
    $handler = $conn->prepare($insert);
    $handler->bindParam(':title',$_POST['title']);
    $handler->bindParam(':due_date',$_POST['due_date']);
    $handler->bindParam(':location',$_POST['location']);
    $handler->bindParam(':cat_id',$_POST['cat_id']);
    $handler->bindParam(':user_created',$_SESSION['user']['id']);

    if($handler->execute()){
        $_SESSION['suscces'] = "Task have been add";
    }else{
        $_SESSION['error'] = "Something went wrong bro";     
    }
    
    header("Location:../app/dashboard.php");
}

if(isset($_POST['task_id'])){
    $update = "UPDATE tasks SET status=:status  WHERE id=:task_id";
    $handler = $conn->prepare($update);
    $handler->bindParam(':task_id',$_POST['task_id']);
    $handler->bindParam(':status',$_POST['status']);
    if($handler->execute()){
        $_SESSION['suscces'] = "Task have been update";
    }else{
        $_SESSION['error'] = "Something went wrong bro , Yes it went wrong";     
    }
    
    header("Location:../app/tasks.php");
}


?>