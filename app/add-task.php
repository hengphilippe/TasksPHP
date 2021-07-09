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

    $query_categories = "SELECT * FROM categories where user_created=  $user_id ";
    $handler = $conn->query($query_categories);
    $categories = $handler->fetchAll();

    // print_r($categories);
    $cat_selected  = isset($_GET['id']) ? $_GET['id'] : "";

    // echo $cat_id;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task : new title</title>
    <link href="https://fonts.googleapis.com/css2?family=Material+Icons"
    rel="stylesheet">
    <link rel="stylesheet" href="./css/main.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
</head>
<body>
    <form method="POST" action="../core/tasks.php">
        <div class="app">
            <div class="container">
                
                <div class="menu">
                    <div class="task-header">
                        <p>New Task</p>
                        <a id="close" class="btnClose">
                            <span class="material-icons">
                                close
                            </span>
                        </a>
                    </div>
                </div>
                
                <!-- <div class="task-title">
                    <p><input type="checkbox">Upgrade Oracle Database Server</p>
                </div> -->

                <div class="task-body">
                    <p>What are your planning? </p>
                    <textarea class="inpt-task" name="title"></textarea>

                    <div class="task-field">
                        <ul>
                            <li class="duedate">
                                <span class="material-icons">
                                notifications_none
                                </span>
                                <input type="text" name="due-date" value="2021-06-30 10:50:00" />
                            </li>
                            <li class="add-category">
                                <span class="material-icons">
                                    bookmark_border
                                </span>
                                <select name="cat_id" required="">
                                        <option>--- please select ---</option>
                                    <?php foreach($categories as $cat) : ?>
                                        <option value="<?= $cat->id ?>"
                                            <?php echo ($cat_selected == $cat->id) ? "selected" : ""  ?> 
                                        > 
                                            <?= $cat->name ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </li>
                            <li class="add-note"><a>
                                <span class="material-icons">
                                    post_add
                                </span>
                                Add more note</a>
                            </li>
                            <li class="add-note"><a>
                                <span class="material-icons">
                                    add
                                    </span>
                                Add a subtask</a>
                            </li>
                            <li class="add-note"><a>
                                <span class="material-icons">
                                    attach_file
                                    </span>
                                Add a attachement</a>
                            </li>
                        </ul>

                        
                    </div>
                </div>

               
            </div>
           
        </div>
        <div class="saveTaskBtn">
            <button type="submit" name="add">Create Task</button>
        </div>
    </form>

    <script type="text/javascript">
        const close = document.querySelector('#close');
        close.addEventListener('click', (e) => {
            window.history.back();
        });
    </script>
</body>
</html>