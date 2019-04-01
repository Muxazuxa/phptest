<?php 
include('../server.php');
if (!isLoggedIn()) {
	$_SESSION['msg'] = "You must log in first";
	header('location: ../login.php');
}
if(!isAdmin()){
	header('location: ../index.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Create user</title>
</head>
<body>
	<h1>Create user</h1>
	<form method='post' action='create_user.php'>
		<ul style="list-style: none;">
			<?php echo display_error(); ?>
			<li><label>Username</label><input type="text" name="username"></li>
			<li><label>First name</label><input type="text" name="first_name"></li>
			<li><label>Last name</label><input type="text" name="last_name"></li>
			<li><label>Born date</label><input type="date" name="born_date"></li>
			<li><label>Password</label><input type="password" name="password_1"></label></li>
			<li><input type="checkbox" id="user_type" name="user_type" value='admin'>
				<label for='user_type'> Is admin ?</label></li>
			<li><label>Password confirmation</label><input type="password" name="password_2"></li>
			<li><button type="submit" name="register" >Save</button></li>
		</ul>
	</form>
</body>
</html>