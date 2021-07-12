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
// 
$sql_all = "SELECT count(1) total FROM tasks where user_created = $user_id";
$handler_all = $conn->query($sql_all);
$allTasks = $handler_all->fetch();
// print_r($allTasks->total);
$sql = "SELECT c.* ,t.cat_id,count(t.id) total_task FROM tasks t LEFT JOIN categories c on  c.id= t.cat_id WHERE  t.user_created = $user_id GROUP BY c.id";

$handler = $conn->query($sql);
$categories = $handler->fetchAll();

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
    <!-- <link rel="stylesheet" href="../app.css"> -->
</head>
<body>
    <div class="app">
        <div class="container">
        
            <!-- //Menu -->
            <div class="menu">
                <span class="material-icons" id="toggle-menu" >segment</span>
                <div class="menu-content" style="display: none;">
                    <a id="btn-login" href="../logout.php">Logout</a>
                    <div id="add_cat" >ADD Category</div>
                </div>
                <?php if(isset($_SESSION['success_register'])){
                    echo "<div class='text-success'><p>" . $_SESSION['success_register'] . "</p></div>";
                    unset($_SESSION['success_register']);
                    } 
                ?>
            </div>

            <!-- //Heading -->
            <div class="heading">
                <h2>Lists</h2>
            </div>

            <!-- //List Catagory of Tasks  -->
            <div class="categoty">
                <ul>
                    <a href="./tasks.php">
                        <li class="alltask">
                                <span class="material-icons">
                                    list_alt
                                </span>
                                <h4>ALL</h4>
                                <p><?= $allTasks->total ?> Tasks</p>
                        </li>
                    </a>

                    <?php foreach ($categories as $category) : ?>
                        <a href="./tasks.php?category=<?= $category->id; ?>">
                            <li class="">
                                    <span class="material-icons" style="color:<?= $category->color_hex ?>">
                                        <?= $category->icons ?>
                                    </span>
                                    <h4><?= strtoupper($category->name) ?></h4>
                                    <p><?= $category->total_task ?> Tasks</p>
                            </li>
                        </a>
                    <?php endforeach; ?>
                </ul>
            </div>
            <!-- //Add <button></button> -->
            <div class="addnew">
                <a href="add_task.php">
                    <span class="material-icons">
                        add
                    </span>
                </a>
                
            </div>
        </div>
        <div class="modal-bg">
            <div class="modal-content">
                <h2>Add Category</h2>
                <span class="close-modal">+</span>
                <form action="../core/category.php" method="POST" class="form">
                    <label for="name">Name
                        <input name="name" type="text">
                    </label>
                    <label for="name">description
                        <input name="description" type="text">
                    </label>
                    <label for="name">icon
                        <input name="icon" type="text">
                    </label>
                    <label for="name">color
                        <input name="color" type="color">
                    </label>
                    <button type="submit" class="btn-add">Add</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>

<script src="./js/main.js"></script>