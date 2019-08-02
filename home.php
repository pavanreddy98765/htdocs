<?php
require 'global_vars.php';
$con = connect_to_db();

if(!isset($_COOKIE["username"]) || ($_COOKIE["username"]=='0'))
   {header("location:index.php");}  
   session_start();
   $_SESSION["username"]=$_COOKIE["username"];
   $user_name=$_SESSION["username"];
   $counter=0;
   if(isset($_COOKIE["time"])&&($_COOKIE["time"]!='0')){
      $_SESSION["time"]=$_COOKIE["time"];
      $var1=$_SESSION["time"];
      $results= mysqli_query($con,"select * from messages where user2='$user_name' and time >'$var1' order by time desc limit 1");

      $counter = mysqli_num_rows($results);
      //echo "hi";
   //$body="abc";
      if($counter){
      while($rows = mysqli_fetch_assoc($results))
      {
         $sent_user=$rows["user1"];
         $body=$rows["message"];
         $time1=$rows['time'];
         $_SESSION["time"] = $time1;
	      setcookie("time",'$time',time() + (86400 * 30));
         //echo "$time";
      }
   }
   }
   

?>

<!DOCTYPE html>
<html lang="en-US">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width" />
      <title>Home</title>
      <link rel="stylesheet" href="home_css/home_components.css">
      <link rel="stylesheet" href="home_css/home_responsee.css">
      <link rel="stylesheet" href="home_css/home_template-style.css">
      <link rel="stylesheet" href="home_css/home_table.css">
      <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
   </head>
   <div class="logo">
<img src="logo.png" alt="logo" width="100%" height="auto">
</div>
   <body >
   
         
         <div class="right">
            <a href="Logout.php">LOGOUT</a>
         </div>
         
   </body>
   <?php
   if($counter){
   echo '<script>';
   echo 'if(window.Notification && Notification.permission !== "denied") {';
      echo 'Notification.requestPermission(function(status) {  ';
         echo "var n = new Notification('New Message From '+'$sent_user', {"; 
            echo "body: '$body',";
            //icon: '/path/to/icon.png' // optional
         echo '});'; 
      echo '});';
   echo '}';
   echo '</script>';
         }
   ?>
</html>
<?php
//session_start();
$username = $user_name;
$var="";
$result= mysqli_query($con,"select name as ename from user WHERE user_name = '$username'") or die('Failed');
while($row = mysqli_fetch_assoc($result))
      {
         echo "Hi, ";
         echo $row['ename']."</td>";
         $var=$row['ename'];
      }
      
?>
<head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width" />
      <title>Home</title>
      <link rel="stylesheet" href="home_css/home_components.css">
      <link rel="stylesheet" href="home_css/home_responsee.css">
      <link rel="stylesheet" href="home_css/home_template-style.css">
      <link rel="stylesheet" href="home_css/home_table.css">
      <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
</head>

   <div class="login-wrap" >      
      <?php
      $result1= mysqli_query($con,"select name as ename, user_name as eid from user WHERE user_name != '$username'") or die('Failed');
      $result2= mysqli_query($con,"select * from messages where user2='$username' order by time desc limit 1");
      while($row1 = mysqli_fetch_assoc($result1))
      {
         $uname=$row1['ename'];
         $uid=$row1['eid'];
         echo "<a href='conversation.php?varname=$uid' class='button'> $uname  </a>";
      }
      $count = mysqli_num_rows($result2);
      //echo "$count";
      if($count){
      while($row2 = mysqli_fetch_assoc($result2))
      {
         $time=$row2['time'];
         $_SESSION["time"] = $time;
	      setcookie("time",$time,time() + (86400 * 30));
         //echo "$time";
      }
   }
      ?>

   </div>


