<?php
require 'global_vars.php';
$con = connect_to_db();
$nameErr = $emailErr = $genderErr = $websiteErr = "";
$name = $email = $gender = $comment = $website = "";
$username = $_POST['user'];
$password = $_POST['pass'];
$password2 = $_POST['pass1'];
$name = $_POST['name'];
$phone = $_POST['phone'];

if($password == '0' || $phone_number == '0' || $username == NULL)
{
	setcookie("error","4");
	header("location: index.php");	
}
$result = mysqli_query($con,"SELECT User_Name FROM user WHERE User_Name = '$username'");
$count = mysqli_num_rows($result);
if($count != 0)
{	
	setcookie("error","2");
	header("location: index.php");
}
else
{	if($password == $password2)
	{
		$hashed_password = password_hash($password, PASSWORD_DEFAULT);
		$ver = mysqli_query($con,"Insert into user Values('$username','$hashed_password','$name')");
	 setcookie("signup","1");
	 header("location: index.php");	
	}
	else
	{setcookie("error","3");
	 header("location: index.php");
	}
}
?>