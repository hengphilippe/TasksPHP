<?php 

session_start();

require_once('database.php');
require_once('../config.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require '../vendor/autoload.php';

//Create an instance; passing `true` enables exceptions

	function checkemail($str) {
		return (preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str));
	}
	function checkpw($str) {
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
	function sendVerifyEmail($name,$email,$vkey){
		$mail = new PHPMailer(true);
		$mail->isSMTP();                                            //Send using SMTP
		$mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
		$mail->SMTPAuth   = true;                                   //Enable SMTP authentication
		$mail->Username   = 'taingchhayse106@gmail.com';                     //SMTP username
		$mail->Password   = '199920691194210161';                               //SMTP password
		$mail->SMTPSecure = "tls";            //Enable implicit TLS encryption
		$mail->Port       = 587;    
		
		//TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
		$mail->setFrom("taingchhayse106@gmail.com",$name);
		$mail->addAddress($email);

		$mail->isHTML(true);
		$mail->Subject = "Email verification from TaskAPP"; 
		$template = "<h2>Thank for sign up for our site!!!</h2><p>Click the link below to verify your email.</p><br>
		<a href='http://localhost/TasksPHP/verify.php?vkey=$vkey'>Click here to verify</a>";
		$mail->Body=$template;
		$mail->send();
		header('Location:../register');
	}
	//check google login page
	if(isset($_GET['code'])){
		$token = $google_client->fetchAccessTokenWithAuthCode($_GET['code']);
			//check if have any invalid login
			if(!isset($token['error'])){
				$oAuth = new Google_Service_Oauth2($google_client);
				$userData = $oAuth->userinfo_v2_me->get();
				//check unique email or not
				if(checkUniqueEmail($userData['email'],$conn)){
					$sql = "INSERT INTO users (name, email, password,verify) VALUES (:name, :email, :password,1)";
					$handler = $conn->prepare($sql);
					$handler->bindValue(':name',$userData['familyName'].' '.$userData['givenName']);
					$handler->bindValue(':email',$userData['email']);
					$handler->bindValue(':password', md5(123));

					if($handler->execute()) {
						$_SESSION['success_register'] = "Account Created.";
						// header("Location: ../login.php");
					}else{
						// if something wrong
						$_SESSION['error'] = "something wrong";
						header("Location: ../register.php");
					}
				}
				
					$sql = "select * from users where email=:email";
					$handler = $conn->prepare($sql);
					$handler->bindValue(':email',$userData['email']);
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
			}else{
				// if something wrong
				$_SESSION['error'] = "something wrong";
				header("Location: ../login.php");
			}

		}
	
	/// register
	if(isset($_POST['name']) && isset($_POST['email']) && isset($_POST['password'])) {
		
		$name = $_POST['name'];
		$email = $_POST['email'];
		$password = $_POST['password'];	
		// not require
		$subcribe = $_POST['subcribe'];
		$vkey = md5(strval(time()).$name);
		//form validation
		if(strlen($name)<4||!checkemail($email)||!checkpw($password)||!checkUniqueEmail($email,$conn)){
			$_SESSION['error_message']=array();
			if(strlen($name)<4){
				$_SESSION['error_message'] += array(
					'name' => 'Name length must > 3',
				);
			}
			if(!checkemail($email)||!checkUniqueEmail($email,$conn)){	
				$_SESSION['error_message'] += array(
					'email' => 'Invalid Email'
				);
				if(!checkUniqueEmail($email,$conn)){
					$_SESSION['error_message'] += array(
						'email_existed' => 'Email Already existed'
					);
				}
			}
			if(!checkpw($password)){
				$_SESSION['error_message'] += array(
					'pw' => 'Invalid password'
				);
			}	
			header("Location: ../register.php");
			return;
		}

		sendVerifyEmail("$name","$email","$vkey");
		
		$sql = "INSERT INTO users (name, email, password,vkey) VALUES (:name, :email, :password,:vkey)";
		$handler = $conn->prepare($sql);
		$handler->bindValue(':name',$name);
		$handler->bindValue(':email',$email);
		$handler->bindValue(':vkey',$vkey);
		$handler->bindValue(':password', md5($password));
		
		// if successfull created
		if($handler->execute()) {
			$_SESSION['success_register'] = "Account Created.";
			$_SESSION['verity'] = "Not yet verify please check your email inbox";
			//send email 
			$subject ="Email verification";
			$content ="";
			header("Location: ../login.php");
		}else{
			// if something wrong
			$_SESSION['error'] = "something wrong";
			header("Location: ../register.php");
			// var_dump($handler->errorInfo());
		}

	}

	/// login
	if(isset($_POST['email']) && isset($_POST['password']) && isset($_POST['login'])) {

		$email = $_POST['email'];
		$password = $_POST['password'];

		$sql = "select * from users where email=:email and password=:password and verify=1";

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
			$_SESSION['error'] = "Invalid email/password or verify your email.";
			header("Location: ../login.php");
		}
		
	}
	
?>