<?php include('../server.php');
//if user is not logged in
if(!isLoggedIn()) {
	$_SESSION['msg'] = "You must log in first";
	header('location: ../login.php');
}
//check for admin
if(!isAdmin()){
	header('location: ../index.php');
}
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Update</title>
</head>
<body>
	<h1>Update page</h1>
	<form method='post' action='update.php'>
		<ul style="list-style: none;">
			<input type="hidden" name="id" value="<?php echo $id; ?>">
			<li><label>Username</label><input type="text" name="username" value="<?php echo $username; ?>"></li>
			<li><label>First name</label><input type="text" name="first_name" value="<?php echo $first_name; ?>"></li>
			<li><label>Last name</label><input type="text" name="last_name" value="<?php echo $last_name; ?>"></li>
			<li><label>Born date</label><input type="date" name="born_date" value="<?php echo $born_date; ?>"></li>
			<li><button type="submit" name="update" >Update</button></li>
		</ul>
	</form>