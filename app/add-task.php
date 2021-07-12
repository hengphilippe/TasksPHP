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
$query_categories = "SELECT * FROM categories WHERE user_created = $user_id";
$handler = $conn->query($query_categories);
$categories = $handler ->fetchAll();

// get id categories
$categories_select = isset($_GET["id"]) ?  $_GET["id"] : "";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Material+Icons"
    rel="stylesheet">
    <link rel="stylesheet" href="./css/main.css">
    <title>addTask</title>
</head>
<body>
    <form action="../core/tasks.php" method="POST">
            <div class="app">
        <div class="container">
            <div class="menu">
                <div class="task-header">
                    <p>New Tasks</p>
                    <a href="#" class="btnClose" id="close">
                        <span class="material-icons">close</span>
                    </a>
                </div>
            </div>
            <!-- task body -->
            <div class="task-body">
                <p>What`s are you planning ?</p>
                <textarea  class="inpt-task" name="title"></textarea>
                <div class="task-field">
    <ul>
        <li class="duedate">
                <span class="material-icons">notifications_none</span>
                <input type="text" name="due-date" value="May 29,10:00AM"/>
        </li>
        <li class="add-category">
                <span class="material-icons">bookmark_border</span>
                <select name="cat_id" require="">
                    <option>---Please select---</option>
                    <?php foreach($categories as $category ) :?>
                        <option 
                        value=<?= $category->id ?> 
                        <?php echo ($categories_select == $category->id) ? "selected" : "" ?>
                        ><?= $category->name ?></option>
                    <?php endforeach; ?>
                </select>
    </li>
    <li class="add-note">
            <a>
                <span class="material-icons">post_add</span>
                Add more note
            </a>
    </li>
    <li class="add-note">
            <a>
                <span class="material-icons">add</span>
                Add a subTask
            </a>
    </li>
    <li class="add-note">
            <a>
                <span class="material-icons">attach_file</span>
                Add a Attachment
            </a>
    </li>
        </ul>
    </div>
    </div>
    </div>
    </div>
    <div class="saveTaskBtn">
        <button type="submit" name="add">Create Tasks</button>
    </div>
    </form>
    <script src="./js-add-task.js">
    </script>
</body>
</html>

