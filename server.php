<?php
session_start();
//variables for database connect and errors
$db = mysqli_connect('localhost', 'root', 'x19990303', 'phptest') or die("Error:" . mysqli_error($db));
$errors = array();

//if register button was clicked
if(isset($_POST['register'])){
  register();
}

//function for handle and save data from the register form
function register(){
  global $db, $errors;
  //get the datas from post method
  $username = e($_POST['username']);
  $first_name = e($_POST['first_name']);
  $last_name = e($_POST['last_name']);
  $born_date = e($_POST['born_date']);
  $password_1 = e($_POST['password_1']);
  $password_2 = e($_POST['password_2']);

  //data check for emptiness
  if(empty($username)){
    array_push($errors, "Username is required");
  }
  if(empty($last_name)){
    array_push($errors, "Last name is required");
  }
  if(empty($first_name)){
    array_push($errors, "First name is required");
  }
  if(empty($born_date)){
    array_push($errors, "Born date is required");
  }
  if(empty($password_1)){
    array_push($errors, "Password is required");
  }
  if($password_1 != $password_2){
    array_push($errors, "The passwords do not match");
  }

  //checking if user with username is already exists
    $user_check_query = "SELECT * FROM users WHERE username='$username' LIMIT 1";
    $result = mysqli_query($db, $user_check_query);
    $user = mysqli_fetch_assoc($result);
    if($user){
      if($user['username']===$username){
      array_push($errors, "Username is already taken, take another one");
      }
    }
  //if no errors
  if(count($errors) == 0){
    $password = md5($password_1);
    //if user is admin
    if($_POST['user_type'] == 'admin'){
      $user_type = e($_POST['user_type']);
      $query = "INSERT INTO users(username, first_name, last_name, born_date, user_type, password)
                VALUES ('$username', '$first_name', '$last_name', '$born_date', '$user_type', '$password')";
      mysqli_query($db, $query);
      $logged_in_user_id = mysqli_insert_id($db);
      $_SESSION['user'] = getUserById($logged_in_user_id);
      $_SESSION['success'] = "New user was succesifully created";
      header('location:home.php');
    }
    //for default users
    else{
      $query = "INSERT INTO users(username, first_name, last_name, born_date, password)
                VALUES ('$username', '$first_name', '$last_name', '$born_date', '$password')";
      mysqli_query($db, $query);

      //get user's id that created
      $logged_in_user_id = mysqli_insert_id($db);
      $_SESSION['user'] = getUserById($logged_in_user_id);
      $_SESSION['success'] = "You are now logged in";
      header('location: index.php');
    }
  }
}

//secure from SQL injection
function e($val){
  global $db;
  return mysqli_real_escape_string($db, trim($val));
}

//Get user information array by id
function getUserById($id){
  global $db;
  $query = "SELECT * FROM users WHERE id=".$id;
  $result = mysqli_query($db, $query);
  $user = mysqli_fetch_assoc($result);
  return $user;
}

//Display errors
function display_error() {
  global $errors;

  if (count($errors) > 0){
    echo '<li>';
      foreach ($errors as $error){
        echo $error;
      }
    echo '</li>';
  }
} 

//check if the user logged in
function isLoggedIn()
{
  if (isset($_SESSION['user'])) {
    return true;
  }else{
    return false;
  }
}

//if user logout
if (isset($_GET['logout'])) {
  session_destroy();
  unset($_SESSION['user']);
  header("location: login.php");
}

//if login button was clicked
if (isset($_POST['login'])) {
  login();
}

// login function
function login(){
  global $db, $username, $errors;

  // get values from post
  $username = e($_POST['username']);
  $password = e($_POST['password']);

  // validate data from form 
  if (empty($username)) {
    array_push($errors, "Username is required");
  }
  if (empty($password)) {
    array_push($errors, "Password is required");
  }

  //no errors on form
  if (count($errors) == 0) {
    $password = md5($password);

    $query = "SELECT * FROM users WHERE username='$username' AND password='$password' LIMIT 1";
    $results = mysqli_query($db, $query);

    if (mysqli_num_rows($results) == 1) { // user found
      // check if user is admin or user
      $logged_in_user = mysqli_fetch_assoc($results);
      if ($logged_in_user['user_type'] == 'admin') {

        $_SESSION['user'] = $logged_in_user;
        $_SESSION['success']  = "You are now logged in";
        header('location: admin/home.php');     
      }else{
        $_SESSION['user'] = $logged_in_user;
        $_SESSION['success']  = "You are now logged in";
        header('location: index.php');
      }
    }else {
      array_push($errors, "Wrong username/password combination");
    }
  }
}

//if the user is admin
function isAdmin()
{
  if (isset($_SESSION['user']) && $_SESSION['user']['user_type'] == 'admin' ) {
    return true;
  }else{
    return false;
  }
}

  //if admin click on edit button
  //get user by id from database
  if (isset($_GET['edit'])) {
    global $db;
    $id = $_GET['edit'];
    $results= mysqli_query($db, "SELECT * FROM users WHERE id=$id");
    $n = mysqli_fetch_array($results);
    $username = $n['username'];
    $first_name = $n['first_name'];
    $last_name = $n['last_name'];
    $born_date = $n['born_date'];
  }

  //if admin click to update button
  if (isset($_POST['update'])) {
  global $db;
  $id = $_POST['id'];
  $username = $_POST['username'];
  $first_name = $_POST['first_name'];
  $last_name = $_POST['last_name'];
  $born_date = $_POST['born_date'];
  mysqli_query($db, "UPDATE users SET username='$username', first_name='$first_name', last_name='$last_name', born_date='$born_date' WHERE id=$id");
  $_SESSION['message'] = "User info was updated!"; 
  header('location: list_users.php');
}

  //deleting user by id
  if (isset($_GET['del'])) {
  global $db;
  $id = $_GET['del'];
  mysqli_query($db, "DELETE FROM users WHERE id=$id");
  $_SESSION['message'] = "User deleted!"; 
  header('location: list_users.php');
}
?>
