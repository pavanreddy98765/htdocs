<?php
require 'global_vars.php';
$con = connect_to_db();
$nameErr = $emailErr = $genderErr = $websiteErr = "";
$name = $email = $gender = $comment = $website = "";
$message = $_POST['message'];

if($username=="")
{
	header("location: home.php");	
}
?>
<?php
   session_start();
   $uname = $_SESSION["username"];
   $uid=$_SESSION["user2"];

   $x=1;
$ver = mysqli_query($con,"Insert into messages Values('$uname','$uid','$message','$x',CURRENT_TIME())");
$str="dfghjk";
$ver1=mysqli_query($con,"Insert into message_test Values('$str')"); 
header("location: conversation.php?varname=$uid");
?>