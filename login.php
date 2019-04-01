<?php include('server.php') ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Login page</title>
</head>
<body>
	<!--Login Form-->
	<form method='post' action='login.php'>
		<ul style='list-style: none;'>
			<li><?php echo display_error(); ?></li>
			<li><label>Username</label><input type='text' name='username'></li>
			<li><label>Password</label><input type='password' name='password'></li>
			<button type="submit" name="login">Login</button>
		</ul>
	</form>
</body>
</html>