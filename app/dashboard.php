<?php 
session_start();
require_once('../core/database.php');
//require_once __DIR__ . '../vendor/autoload.php';
if(isset($_SESSION['loginfb'])){
    if(!isset($_SESSION['access_token'])){
        header("Location: ../login.php");
        exit();
    }
    echo($_SESSION['userData']['id']);
    echo($_SESSION['userData']['name']);
    echo($_SESSION['userData']['email']);
    $sql_all = "SELECT count(1) total FROM tasks";
    $handler_all = $conn->query($sql_all);
    $allTasks = $handler_all->fetch(PDO::FETCH_ASSOC);

    $sql = "SELECT b.* ,a.cat_id,count(a.id) total_task FROM tasks a LEFT JOIN categories b on a.cat_id = b.id GROUP BY a.cat_id";

    $handler = $conn->query($sql);
    $categories = $handler->fetchAll();
}
else if(!isset($_SESSION['user'])) {
	// response error to login while invalid user
	// 1. redirect to login page with message error
	// 2. display message error to screen
    $_SESSION['error'] = "Error 401! Unauthorize access.";
    header("Location: ../login.php");
}else{
    // get user auth id
    $user_id =  $_SESSION['user']['id'];
    // 
    $sql_all = "SELECT count(1) total FROM tasks where user_created =$user_id";
    $handler_all = $conn->query($sql_all);
    $allTasks = $handler_all->fetch(PDO::FETCH_ASSOC);

    $sql = "SELECT b.* ,a.cat_id,count(a.id) total_task FROM tasks a LEFT JOIN categories b on a.cat_id = b.id WHERE  a.user_created = $user_id GROUP BY a.cat_id";

    $handler = $conn->query($sql);
    $categories = $handler->fetchAll();
}

// print_r($categories);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Note all your Tasks here</title>
    <link href="https://fonts.googleapis.com/css2?family=Material+Icons"
      rel="stylesheet">
    <link rel="stylesheet" href="./css/main.css">
</head>
<body>
    
    <div class="app">

        <div class="container">
            <!-- //Menu -->
            <div class="menu">
                <span class="material-icons">
                    segment
                </span>
                
            </div>
            <a href="../logout.php">logout</a>
            <!-- //Heading -->
            <div class="heading">
                <h2>Lists</h2>
            </div>

            <!-- //List Catagory of Tasks  -->
            <div class="categoty">
                <ul>
                    <li class="alltask">
                        <a href="./tasks.php">
                            <span class="material-icons">
                                list_alt
                            </span>
                            
                            <h4>ALL</h4>
                            <p><?= $allTasks['total'] ?> Tasks</p>
                        </a>
                    </li>

                    <?php foreach ($categories as $category) : ?>
                    	<li class="">
	                        <a href="./tasks.php?category=<?= $category['id']; ?>">
	                            <span class="material-icons">
	                                <?= $category['icons'] ?>
	                            </span>
	                            <h4><?= strtoupper($category['name']) ?></h4>
	                            <p><?= $category['total_task'] ?> Tasks</p>
	                        </a>
                    	</li>
                    <?php endforeach; ?>

                   <!--  <li class="work">
                        <a href="./todo.html">
                        <span class="material-icons">
                            work_outline
                            </span>
                        <h4>Work</h4>
                        <p>12 Tasks</p>
                    </a>
                    </li>
                    <li class="music">
                        <a href="./todo.html">
                        <span class="material-icons">
                            headphones
                            </span>
                        <h4>Music</h4>
                        <p>2 Tasks</p>
                    </a>
                    </li>
                    <li class="travel">
                        <a href="./todo.html">
                        <span class="material-icons">
                            flight_takeoff
                            </span>
                        <h4>Travel</h4>
                        <p>1 Tasks</p></a>
                    </li>
                    <li class="study">
                        <a href="./todo.html">
                        <span class="material-icons">
                            devices
                            </span>
                        <h4>Study</h4>
                        <p>7 Tasks</p>
                    </a>
                    </li>
                    <li class="home">
                        <a href="./todo.html">
                        <span class="material-icons">
                            roofing
                            </span>
                        <h4>Home</h4>
                        <p>7 Tasks</p>
                    </a>
                    </li> -->
                </ul>
            </div>

            <!-- //Add <button></button> -->
            <a class="addnew" href="./add-task.php">
                <span class="material-icons">
                    add
                </span>
            </a>
        </div>
    </div>
</body>
</html>