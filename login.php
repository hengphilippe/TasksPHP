<?php 
session_start();

require_once('./vendor/vendor/autoload.php');
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
						<p>Doesn't have an account yet? <a href="./register.php"><strong>Sign Up</strong></a> here</p>
						
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
					<?php
				$clientId = "68873135318-lrji6ms6etstfp06mn6cris1lf1vnaal.apps.googleusercontent.com";
				$clientSecret = "gFqXBGQ09OtWMdFOJGb3exX6";
				$redirectUri = "http://localhost/add-task/login.php";

				// create client request
				$client = new Google_Client();
				$client->setClientId($clientId);
				$client->setClientSecret($clientSecret);
				$client->setRedirectUri($redirectUri);
				$client->addScope('email');
				$client->addScope('profile');

				if(isset($_GET["code"])) {
					$token = $client->fetchAccessTokenWithAuthCode($_GET["code"]);
					$client->setAccessToken($token["access_token"]);
					// Get Profile Information
					$google_oauth = new Google_Service_Oauth2($client);
					$google_account_info = $google_oauth->userinfo->get();
					$email = $google_account_info->email;
					$name = $google_account_info->name;
					$picture = $google_account_info->picture;
					
				echo "<table>";
				echo "<tr>";
				echo "<td>".$name."</td>";
				echo "<td>".$email."</td>";
				echo "</tr>";
				echo "</table>";

				}else {
					echo "<a href=".$client->createAuthUrl()."><div class='google'>Login with Google</div></a>";
				}
					?>
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