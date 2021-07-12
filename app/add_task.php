<?php
session_start();
require_once('../core/database.php');
$user_id = $_SESSION['user']['id'];
$select = "SELECT * FROM categories WHERE user_created =".$user_id."";
$handler = $conn->query($select);
$all_cat = $handler->fetchAll();
$cat_id = (isset($_GET['category']))?$_GET['category']:0;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./css/main.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/themes/dark.css">
</head>
<body>
<div class="add_task_bg">
    <div class="modal-bg" style="display: flex;">
    <div class="modal-content">
        <h2>Add Task</h2>
        <span class="close-modal task">+</span>
        <form action="../core/task.php" method="POST">
            <label for="title">Title
                <input name="title" type="text">
            </label>
            <label for="due_date">Due Date
                <input name="due_date" id="due_date" type="text">
            </label>
            <label for="location">Location
                <input name="location" type="text">
            </label>
            <label for="attachment">Attachment
                <input name="attachments" type="text">
            </label>
            <label for="category">Category
                <select name="cat_id" id="cat">
                    <?php foreach($all_cat as $cat){?>
                    <option value="<?=$cat->id?>" <?=($cat->id==$cat_id)?'selected':'';?>><?=$cat->name?></option>
                    <?php }?>
                </select>
            
            </label>
            <button type="submit" class="btn-add">Add</button>
        </form>
    </div>
    </div>


</div>
    
</body>
</html>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    flatpickr("#due_date", {
        enableTime: true,
        dateFormat: "Y-m-d H:i",
    });
    document.querySelector(".close-modal").addEventListener('click',()=>{
        window.history.back();
    })
</script>