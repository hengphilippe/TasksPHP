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
<form method="POST" action="../core/categories.php">
    <div class="app">
        <div class="container">

            <div class="menu">
                <div class="task-header">
                    <p>Add New Category</p>
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
                <form action="/action_page.php">
                    <label for="fname">Category Name</label>
                    <input type="text" id="fname" name="name" placeholder="Category Name">

                    <label for="fname">description</label>
                    <input type="text" id="dsc" name="description" placeholder="description">
                    <label for="fname">description</label>
                    <input type="text" id="icon" name="icons" placeholder="icon">
                    <label for="fname">color Hex</label>
                    <input type="text" id="color" name="color_hex" placeholder="color">


                    <button style=" background-color: #4CAF50; /* Green */
  border: none;
  color: white;
  padding: 15px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;"type="submit" name="add_cate">Create Category</button>
                </form>
            </div>


        </div>

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