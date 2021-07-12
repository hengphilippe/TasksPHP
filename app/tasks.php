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

if ($category_id !== 0) {
$query_cat = "SELECT * FROM categories WHERE id = :id";
$handler_cat = $conn->prepare($query_cat);
$handler_cat->bindParam(":id",$category_id);
$handler_cat->execute();
$desc_cat = $handler_cat->fetch();
}
// print_r($desc_cat);
 
$where_query = ($category_id == 0) ? "WHERE tasks.user_created=$user_id" : 
				"WHERE tasks.user_created=$user_id AND tasks.cat_id=$category_id";
$sql = "SELECT tasks.*, categories.name, categories.color_hex FROM tasks LEFT JOIN categories ON tasks.cat_id = categories.id $where_query";
$handler = $conn->query($sql);
$tasks = $handler->fetchAll();

// print_r($tasks);

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
    <div class="app category" style="background-color: <?= $desc_cat->color_hex ?>">
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
                <?php if($category_id !== 0) :?>
                <span class="material-icons">
                    <?= $desc_cat->icons ?>
                </span>
                <h4><?= strtoupper($desc_cat->name)?></h4>
                <?php  else :?>
                   <span class="material-icons">
                    list_alt
                </span>
                <h4>All</h4>
                    <?php  endif; ?>
                        <p><?= count($tasks); ?>Tasks</p>
            </div>
        </div>

        <div class="task-list">
            <!-- <div class="list-group">
                <div class="title">
                    <span>Late</span>
                </div>
                <div class="lists">
                    <a class="list" href="newtask.html">
                        <div class="detail">
                            <p class="task">Update Slide For E-Commerce Classs & Drink More coffee</p>
                            <p class="duedate late">20:15 PM April 29</p>
                            <p><span class="tag study">School</span></p>
                        </div>
                        <div class="action">
                            <input type="checkbox">
                        </div>
                    </a>
                  
                </div>
            </div> -->

            <div class="list-group">
                <div class="title">
                    <span>Today</span>
                </div>
                <div class="lists">
                	<?php foreach ($tasks as $task) : ?>
                		<a class="list" href="#">
	                        <div class="detail">
	                            <p class="task"><?= $task->title; ?> </p>
	                            <p class="duedate "><?= $task->due_date; ?></p>
	                            <p><span class="tag work" style="color: <?= $task->color_hex; ?>; "><?= $task->name; ?></span></p>
	                        </div>
	                        <div class="action">
	                            <input type="checkbox" value="<?= $task->id ?>">
	                        </div>
                    	</a>
                	<?php endforeach; ?>
                    <!-- <a class="list" href="newtask.html">
                        <div class="detail">
                            <p class="task">Buying Coffee</p>
                            <p class="duedate ">08:15 AM</p>
                            <p><span class="tag home">Home</span></p>
                        </div>
                        <div class="action">
                            <input type="checkbox">
                        </div>
                    </a>
                    <a class="list" href="newtask.html">
                        <div class="detail">
                            <p class="task">Upgrade Oracle Database Server</p>
                            <p class="duedate ">10:00 AM</p>
                            <p><span class="tag work">Work</span></p>
                        </div>
                        <div class="action">
                            <input type="checkbox">
                        </div>
                    </a>
                    <a class="list" href="newtask.html">
                        <div class="detail">
                            <p class="task">Meeting with Scott</p>
                            <p class="duedate ">11:00 AM</p>
                            <p><span class="tag work">Work</span></p>
                        </div>
                        <div class="action">
                            <input type="checkbox">
                        </div>
                    </a>
                   -->
                </div>
            </div>

            <div class="list-group">
                <div class="title">
                    <span>Done</span>
                </div>
                <!-- <div class="lists">
                    <a class="list" href="newtask.html">
                        <div class="detail">
                            <p class="task">DailyBackup Procesdure</p>
                            <p class="duedate">20:15 PM April 29</p>
                            <p><span class="tag work">Work</span></p>
                        </div>
                        <div class="action">
                            <input type="checkbox">
                        </div>
                    </a>
                  
                </div> -->
            </div>
        </div>
        <div class="mask">
    
        </div>
        <!-- //Add <button></button> -->
        <a class="addnew" href="./add-task.php?id=<?= $category_id ?>">
            <span class="material-icons">
                add
            </span>
        </a>
    </div>

    <script src="./scipt/app.js"></script>
  <script>
     let checkboxs = window.document.querySelectorAll(".action input");
     for (let checkbox of checkboxs) {
        checkbox.addEventListener("change", function(e) {
            var xhttp = new XMLHttpRequest();
                xhttp.open("POST", "../core/ajax.php", true); 
                xhttp.setRequestHeader("Content-Type", "application/json");
                xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    // Response
                    var response = this.responseText;
                    console.log(response);
                }
                };
                var data = { $task:1 };
                xhttp.send(JSON.stringify(data));
                });
            }
  </script>
</body>
</html>