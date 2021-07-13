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

if(isset($_POST['add_cate'])){


    $name = $_POST['name'];
    $description = $_POST['description'];
    $icons = $_POST['icons'];
    $color_hex = $_POST['color_hex'];
    $statement = "INSERT INTO categories (name, description, icons, color_hex, user_created) VALUES (:cate_name, :description, :icons, :color_hex, $user_id)";
    $handler = $conn->prepare($statement);

    $handler->bindParam(":name", $name);
    $handler->bindParam(":description", $description);
    $handler->bindParam(":icons", $icons);
    $handler->bindParam(":due_date", $due_date);
    $handler->bindParam(":cat_id", $category);

    if($handler->execute()){
        header("Location: ../app/tasks.php?category=".$category);
    }
    else {
        echo "Error! something wrong";
    }
}