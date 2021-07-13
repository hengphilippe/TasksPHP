<?php 
//session_start();
require_once('config.php');
if(isset($_SESSION['access_token'])){
	header("Location: app/dashboard.php");
	exit();
}
$redirectTo = "http://localhost:8080/TasksPHP/callback.php";
$data = ['email'];
$fullURL = $handler->getLoginUrl($redirectTo, $data);
?>
<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="app.css">

</head></html>
<body>
	<div id="fb-root"></div>

	<div class="split-screen">
		<div class="left">
			<section class="copy">
				<h1>Explore your tasks</h1>
				<p>Over 1000 tasks free to added.</p>
			</section>
		</div>
		<div class="right">

			<form action="core/auth.php" method="POST">
				<section class="copy">
					<h2>Loign</h2>
					<div class="login-container">
						<p>Don't have an account yet? <a href="register.php"><strong>Sign Up</strong></a> here</p>
					</div>
				</section>
				<?php if(isset($_SESSION['success_register'])){
					echo "<p style='color:red;'>" . $_SESSION['success_register'] . "</p>";
					unset($_SESSION['success_register']);
					}
					if(isset($_SESSION['error_register'])){
						echo "<p style='color:red;'>" . $_SESSION['success_register'] . "</p>";
						unset($_SESSION['error_register']);
					}
				?>
				<div class="frm-inpt email">
					<label>Email:</label>
					<input type="email" name="email">
				</div>
				<div class="frm-inpt password">
					<label>Password:</label>
					<input type="password" name="password">
					<!-- <span class="material-icons-outlined">
					visibility
					</span> -->
				</div>
					<button style="margin:5px" class="btn-submit" type="submit" name="login">Log In</button>
					<p class="text2" style="font-size: 16px; font-family: 'Roboto Slab', serif; position: static; text-align: center; left: 40%; color: gray">or login with</p>

					<?php echo '<a href="' . $fullURL . '"><p style="text-align: center;">Facebook</p></a>'; $_SESSION['loginfb']="new";?>

					<!-- <div class="fb-login-button" data-width="" data-size="large" data-button-type="continue_with" data-layout="default" data-auto-logout-link="false" data-use-continue-as="false"></div>
					 -->

			</form>
		</div>
		<?php if(isset($_SESSION['error'])){
				echo "<p style='color:red;'>" . $_SESSION['error'] . "</p>";
				unset($_SESSION['error']);
				} 
			?>
	</div>
</body>
</html>	