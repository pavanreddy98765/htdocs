<?php
require 'global_vars.php';
$con = connect_to_db();

$username = $_POST['user'];
$password = $_POST['pass'];
$count=0;
$result = mysqli_query($con,"SELECT * FROM user WHERE user_name = '$username'");
while($row = mysqli_fetch_assoc($result))
      {
		 $hashed_password=$row['user_password'];
		 if(password_verify($password, $hashed_password)) {
			 $count=1;
		 }

      }
if($count == 1)
{
	$row = mysqli_fetch_array($result);
	session_start();
	$_SESSION["username"] = $username;
	setcookie("username",$username,time() + (86400 * 30));	
	header("location:home.php");
	
}
else
{
	setcookie("error","1");
	header("location: index.php");
}
?>