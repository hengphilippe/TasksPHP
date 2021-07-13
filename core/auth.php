<?php 
session_start();
require_once('../config.php');
require_once('database.php');
include('../login.php');
	function checkemail($str) {
		return (preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str));
	}
	function checkpassword($str) {
		return (preg_match("/^(?=.*[!@#$%^&*])(?=.*[0-9])(?=.*[A-Z]).{8,25}$/", $str));
	}
	function checkUniqueEmail($email,$conn){
		$sql_all = "SELECT email FROM users WHERE users.email='{$email}'";
		$handler_all = $conn->query($sql_all);
		$allTasks = $handler_all->fetch();
		if(!empty($allTasks)){
			return false;
		}
		return true;
	}
	/// register
	if(isset($_POST['name']) && isset($_POST['email']) && isset($_POST['password'])) {
		
		$name = $_POST['name'];
		$email = $_POST['email'];
		$password = $_POST['password'];	
	//echo($name);
		// not require
		//$subcribe = $_POST['subcribe'];
		
		//form validation
		if(strlen($name)<4||!checkemail($email)||!checkpassword($password)||!checkUniqueEmail($email,$conn)){
			$_SESSION['error_message']=array();
			if(strlen($name)<4){
				echo('love');
				$_SESSION['error_message'] += array(
					'name' => 'Name length must greater than 3',
				);
			}
			if(!checkemail($email)||!checkUniqueEmail($email,$conn)){	
				echo('yeah');
				$_SESSION['error_message'] += array(
					'email' => 'Invalid Email'
				);
				if(!checkUniqueEmail($email,$conn)){
					echo('hi');
					$_SESSION['error_message'] += array(
						'email_existed' => 'Email Already existed'
					);
				}
			}
			if(!checkpassword($password)){
				echo('hi');
				$_SESSION['error_message'] += array(
					'pw' => 'Invalid password'
				);
			}	
			header("Location: ../register.php");
			return;
		}else{
			$sql = "INSERT INTO users (name, email, password) VALUES ('{$user}', '{$email}', '{$password}')";
			$handler = $conn->prepare($sql);
			$handler->bindValue(':name',$name);
			$handler->bindValue(':email',$email);
			$handler->bindValue(':password', md5($password));
			$handler->execute();
			
			
			//if successfull created
			if($handler->execute()) {
				$_SESSION['success_register'] = "Account Created.";
				
			}else{
				// if something wrong
				$_SESSION['error_register'] = "something wrong";
				//header("Location: ../register.php");
			}
		}

	}
	/// login
	if(isset($_POST['email']) && isset($_POST['password']) && isset($_POST['login'])) {

		$email = $_POST['email'];
		$password = $_POST['password'];

		$sql = "SELECT * from users where email='{$email}' and password='{$password}'";

		$handler = $conn->prepare($sql);
		$handler->bindValue(':email',$email);
		$handler->bindValue(':password', md5($password));
		$handler->execute();
		$user = $handler->setFetchMode(PDO::FETCH_ASSOC);
		$user = $handler->fetch(PDO::FETCH_ASSOC);
		if($user) {
			$_SESSION['user'] = array(
				'id' =>  $user['id'],
				'name' => $user['name'],
				'email' => $user['email']
				 );
			
			header("Location: ../app/dashboard.php");
		}else {
			// response error to login while invalid user
			// 1. redirect to login page with message error
			// 2. display message error to screen
			// $_SESSION['error'] = "Error 401! Please login first in order to access that.";
			$_SESSION['error'] = "Invalid email or password.";
			header("Location: ../login.php");
		}
	}
	
?>