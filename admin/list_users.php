<?php include('../server.php');
//check for login user
if(!isLoggedIn()) {
	$_SESSION['msg'] = "You must log in first";
	header('location: ../login.php');
}
//check for admin
if(!isAdmin()){
	header('location: ../index.php');
}
//take all users form db
$query = "SELECT * FROM users";
$results = mysqli_query($db, $query)
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>List of users</title>
	<!--function for confirmation delete -->
	<script language="JavaScript" type="text/javascript">
		function checkDelete(){
    return confirm('Are you sure?');
}
</script>
</head>
<body>
	<h2>List of users</h2>
	<!--notification messages -->
	<?php if(isset($_SESSION['message'])){
		echo $_SESSION['message'];
		unset($_SESSION['message']);
	}?>
	<table>
	<thead>
		<tr>
			<th>Username</th>
			<th>First name</th>
			<th>Last name</th>
			<th>Born date</th>	
			<th colspan="2">Action</th>
		</tr>
	</thead>
	<!--take users form results-->
	<?php while ($row = mysqli_fetch_array($results)) { ?>
		<tr>
			<td><?php echo $row['username']; ?></td>
			<td><?php echo $row['first_name']; ?></td>
			<td><?php echo $row['last_name']; ?></td>
			<td><?php echo $row['born_date']; ?></td>
			<td>
				<a href="update.php?edit=<?php echo $row['id']; ?>" name="edit">Edit</a>
			</td>
			<td>
				<a href="list_users.php?del=<?php echo $row['id']; ?>" onclick="return checkDelete()">Delete</a>
			</td>
		</tr>
	<?php } ?>
</table>
</body>
</html>