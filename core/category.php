<?php 
session_start();
require_once('database.php');


    $insert = "INSERT INTO categories (name,description,icons,color_hex,user_created) VALUE (:name,:description,:icons,:color_hex,:user_created)";
    $handler = $conn->prepare($insert);
    $handler->bindParam(':name',$_POST['name']);
    $handler->bindParam(':description',$_POST['description']);
    $handler->bindParam(':icons',$_POST['icon']);
    $handler->bindParam(':color_hex',$_POST['color']);
    $handler->bindParam(':user_created',$_SESSION['user']['id']);

    if($handler->execute()){
        $_SESSION['suscces'] = "Category have been add";
        header("Location:../app/dashboard.php");

    }else{
        $_SESSION['error'] = "Something went wrong bro";
        header("Location:../app/dashboard.php");
    }




?>