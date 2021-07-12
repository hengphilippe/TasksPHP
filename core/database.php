<?php 

$host = "localhost";
$dbname = "sq5TaskApp";
$user= "root";
$password='';

$dns = "mysql:host=$host;dbname=$dbname";

$conn = new PDO($dns, $user, $password);
$conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);