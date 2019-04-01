<?php include ('server.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Register page</title>
</head>
<body>
	<h1> Registration Page</h1>
	<ul style="list-style: none;">
		<?php
			echo display_error();
		?>
	</ul>
	<!--Registration Form -->
	<form method="post" action="register.php">
		<ul style="list-style: none;">
			<li><label>Username</label><input type="text" name="username"></li>
			<li><label>First name</label><input type="text" name="first_name"></li>
			<li><label>Last name</label><input type="text" name="last_name"></li>
			<li><label>Born date</label><input type="date" name="born_date"></li>
			<li><label>Password</label><input type="password" name="password_1"></label></li>
			<li><label>Password confirmation</label><input type="password" name="password_2"></li>
			<li><button type="submit" name="register" >Save</button></li>
		</ul>
	</form>
</body>
</html>