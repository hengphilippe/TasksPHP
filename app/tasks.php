<?php 

session_start();
require_once('../core/database.php');
if(!isset($_SESSION['user'])) {
	// response error to login while invalid user
	// 1. redirect to login page with message error
	// 2. display message error to screen
	header("Location: ../login.php");
}
// get user auth id
$user_id =  $_SESSION['user']['id'];

$category_id = (isset($_GET['category'])) ? $_GET['category'] : 0;
$where_query = ($category_id == 0) ? "WHERE user_created=$user_id" : 
				"WHERE user_created=$user_id AND cat_id=$category_id ";
$status_no = " AND status=0";
$status_yes = " AND status=1";

$sql = "SELECT * FROM tasks $where_query $status_no ";
$handler = $conn->query($sql);
$tasks = $handler->fetchAll();

$sql_sec = "SELECT * FROM tasks $where_query $status_yes ";
$handler_sec = $conn->query($sql_sec);
$tasks_complete = $handler_sec->fetchAll();
$all_task = count($tasks);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task List</title>
    <link href="https://fonts.googleapis.com/css2?family=Material+Icons"
    rel="stylesheet">
  <link rel="stylesheet" href="./css/main.css">
</head>
<body>
    <div class="app category bg-primary">
        <div class="container">
            <div class="menu">
                <a href="./dashboard.php">
                <span class="material-icons">
                    chevron_left
                </span>
                </a>
                <span class="material-icons">
                    more_vert
                    </span>
            </div>
            <div class="sub-heading">
                <span class="material-icons">
                    list_alt
                </span>
                <h4>All</h4>
                <p> <?=$all_task ?>Tasks</p>
            </div>
        </div>

        <div class="task-list">
            <div class="list-group">
                <div class="title">
                    <span>Today</span>
                </div>
                <div class="lists">
                    <form method="POST" id="update_status" action="../core/task.php">
                	<?php foreach ($tasks as $task) : ?>
                		<a class="list" href="#">
	                        <div class="detail">
	                            <p class="task"><?= $task->title; ?> </p>
	                            <p class="duedate "><?= $task->due_date; ?></p>
	                            <p><span class="tag work"><?= $task->cat_id ?></span></p>
	                        </div>
	                        <div class="action">
	                            <input type="checkbox" name="task_id" class="done" value="<?= $task->id?>">
                                <input type="hidden" name="status" value="1">
	                        </div>
                    	</a>
                	<?php endforeach; ?>
                    </form>
                </div>
            </div>

            <div class="list-group">
                <div class="title">
                    <span>Done</span>
                </div>
                <div class="lists">
                    <form method="POST" id="update_status_undone" action="../core/task.php">
                	<?php foreach ($tasks_complete as $task) : ?>
                		<a class="list" href="#">
	                        <div class="detail">
	                            <p class="task"><?= $task->title; ?> </p>
	                            <p class="duedate "><?= $task->due_date; ?></p>
	                            <p><span class="tag work"><?= $task->cat_id ?></span></p>
	                        </div>
	                        <div class="action">
	                            <input type="checkbox" name="task_id" class="undone" value="<?= $task->id?>">
	                            <input  type="hidden" name="status" value="0">
	                        </div>
                    	</a>
                	<?php endforeach; ?>
                    </form>
                </div>



            </div>
        </div>
        <!-- //Add <button></button> -->
        <a href="add_task.php?category=<?= $category_id ?>">
            <div class="addnew">
                
                <span class="material-icons">
                    add
                </span>
            </div>
        </a>
        
    </div>
<!-- 
    <script src="./scipt/app.js"></script> -->
</body>
</html>

<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script>
    $('.undone').click(()=>{
        $('#update_status_undone').submit();
    })
    $('.done').click(()=>{
        $('#update_status').submit();
    })
</script>