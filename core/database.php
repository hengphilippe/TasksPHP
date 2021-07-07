<?php 
$host = "localhost";
$dbname="test";
$user = "root";
$password = "";
$dns = "mysql:host=$host;dbname=$dbname";
$conn = new PDO($dns, $user, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// try {
//   $stmt = $conn->prepare("SELECT * FROM users where id=1");
//   $stmt->execute();

//   //set the resulting array to associative
//   $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
//   $user=$stmt->fetchAll(PDO::FETCH_ASSOC);
//   //print_r($stmt);
//   // foreach($user as $k=>$v) {
//   //   print_r($v);
//   // }
  

// } catch(PDOException $e) {
//   echo "Error: " . $e->getMessage();
// }
//$conn = null;