<?php 
session_start();

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
						<p>Doesn't have an account yet? <a href="login.php"><strong>Sign Up</strong></a> here</p>
						
					</div>
				</section>

				<div class="frm-inpt email">
					<label>Email Address:</label>
					<input type="email" name="email">
				</div>
				<div class="frm-inpt password">
					<label>Password:</label>
					<input type="password" name="password">
					<!-- <span class="material-icons-outlined">
					visibility
					</span> -->
				</div>

				<button class="btn-submit" type="submit" name="login">Log in</button>
				
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