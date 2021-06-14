<?php 

session_start();

require_once('database.php');
	
	/// register
	if(isset($_POST['name']) && isset($_POST['email']) && isset($_POST['password'])) {
		
		$name = $_POST['name'];
		$email = $_POST['email'];
		$password = $_POST['password'];

		// not require
		$subcribe = $_POST['subcribe'];

		$sql = "INSERT INTO users (name, email, password) VALUES (:name, :email, :password)";

		$handler = $conn->prepare($sql);
		$handler->bindValue(':name',$name);
		$handler->bindValue(':email',$email);
		$handler->bindValue(':password', md5($password));
		
		// if successfull created
		if($handler->execute()) {
			$_SESSION['success_register'] = "Account Created.";
			header("Location: ../login.php");
		}else{
			// if something wrong
			$_SESSION['error'] = "something wrong";
			header("Location: ../register.php");
		}

	}

	/// login
	if(isset($_POST['email']) && isset($_POST['password']) && isset($_POST['login'])) {

		$email = $_POST['email'];
		$password = $_POST['password'];

		$sql = "select * from users where email=:email and password=:password";

		$handler = $conn->prepare($sql);
		$handler->bindValue(':email',$email);
		$handler->bindValue(':password', md5($password));
		$handler->execute();
		$user = $handler->fetch();
		if($user) {
			$_SESSION['user'] = array(
				'id' =>  $user->id,
				'name' => $user->name,
				'email' => $user->email
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