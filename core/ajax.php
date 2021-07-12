<?php 
	// Read POST data
   $data = json_decode(file_get_contents("php://input"));

   $id = $data['taskid'];
	echo "taskid is : " . $id;

?>