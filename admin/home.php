<?php 
include('../server.php');

if (!isAdmin()) {
	$_SESSION['msg'] = "You must log in first";
	header('location: ../login.php');
}

if (isset($_GET['logout'])) {
	session_destroy();
	unset($_SESSION['user']);
	header("location: ../login.php");
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Home</title>
</head>
<body>
	<h2>Home Page</h2>
		<?php if(isset($_SESSION['success'])){echo $_SESSION['success']; unset($_SESSION['success']);} ?>
		<?php if(isset($_SESSION['msg'])){echo $_SESSION['msg']; unset($_SESSION['msg']);} ?>
	<div class="content">
		<!-- notification message -->
		<?php if (isset($_SESSION['success'])) : ?>
			<div class="error success" >
				<h3>
					<?php 
						echo $_SESSION['success']; 
						unset($_SESSION['success']);
					?>
				</h3>
			</div>
		<?php endif ?>
		<!-- logged in user information -->
		<div>
			<div>
				<?php  if (isset($_SESSION['user'])) : ?>
					<strong><?php echo $_SESSION['user']['username']; ?></strong>
					<strong><i><?php echo $_SESSION['user']['user_type']; ?></i></strong>
					<small>
						<a href="index.php?logout" style="color: red;">logout</a>
					</small>
				<?php endif ?>
			</div>
		</div>
	</div>
</body>
</html>