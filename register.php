<?php 
session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Register</title>
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
					<h2>SignUp</h2>
					<div class="login-container">
						<p>Already have an account? <a href="login.php"><strong>Log In</strong></a></p>
						<p class="text-error"><?php if(isset($_SESSION['error_message'])) {
							foreach($_SESSION['error_message'] as $key => $value){
								echo'-  '. $value.'<br>';
							}
						}
						unset($_SESSION['error_message']);
						?></p>
					</div>
				</section>

				<div class="frm-inpt name">
					<label for="name">Full Name:</label>
					<input type="text" name="name" required>
				</div>
				<div class="frm-inpt email">
					<label>Email Address:</label>
					<input type="text" name="email" >
				</div>
				<div class="frm-inpt password">
					<label for="password">Password:</label>
					<input type="password" name="password" required>
					<p style="font-size: 12px;">Example: ASdf123!@#</p>
					<!-- <span class="material-icons-outlined">
					visibility
					</span> -->
				</div>

				<div class="frm-inpt ck-box">
					<label class="checkbox-container">
						<input type="checkbox" name="subcribe">
						<span class="checkmark"></span>
						Sign up for email updates.
					</label>
				</div>
				<button class="btn-submit" type="submit">Sign Up</button>
				<section class="copy legal">
					<p><span class="small">
						By continuing, you agree to accept our <br > 
						<a href="#">Privacy</a> &amp; <a href="#">Terms of conditions</a></span></p>
					</span>
				</section>
			</form>
		</div>
	</div>
</body>
</html>	