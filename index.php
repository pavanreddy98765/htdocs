<?php
require 'global_vars.php';
if((isset($_COOKIE["username"])) && ($_COOKIE["username"]!='0'))
   {header("location:home.php");}
?>

<html>
<head>
  <meta charset="UTF-8">
  <title>Login Page</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  
  <link rel='stylesheet prefetch' href='http://fonts.googleapis.com/css?family=Open+Sans:600'>

      <link rel="stylesheet" href="css/index_style.css">

  
</head>

<body>
<div class="logo">
<img src="logo.png" alt="logo" width="100%" height="auto">
</div>

  <div class="login-wrap">
	<div class="login-html">
		<input id="tab-1" type="radio" name="tab" class="sign-in" checked><label for="tab-1" class="tab">Sign In</label>
		<input id="tab-2" type="radio" name="tab" class="sign-up"><label for="tab-2" class="tab">Sign Up</label>
		<div class="login-form">
		<form action="./checklogin.php" method="POST">
			<div class="sign-in-htm">
			<h3 style='color:black;'>Login</h3>
				<div class="group">
					<input name="user" type="text" class="input" required = "required" placeholder="Enter Email">
				</div>
				<div class="group">
					<input name="pass" type="password" class="input" data-type="password" required = "required" placeholder="Password">
				</div>			
				<br>
				<?php
				if (isset($_COOKIE["signup"])) 
				{
					if($_COOKIE["signup"]=="1")
					{echo "<h3>Successful. You can login now</h3>";}
					setcookie("signup", "0", time()-120);
				}
				elseif(isset($_COOKIE["error"]))
				{
					if($_COOKIE["error"]=="1")
					{
						echo "<h5 style='color:red;'>Invalid Username or Password</h3>";
					}
					elseif($_COOKIE["error"]=="2")
					{
						echo "<h5 style='color:red;'>Username Already Exists</h3>";
					}
					elseif($_COOKIE["error"]=="3")
					{
						echo "<h5 style='color:red;'>Passwords donot match</h3>";
					}
					elseif($_COOKIE["error"]=="4")
					{
						echo "<h5 style='color:red;'>Please enter valid details</h3>";
					}
					elseif($_COOKIE["error"]=="5")
					{
						echo "<h5 style='color:red;'>Wrong Email Format</h3>";
					}
					setcookie("error", "0", time()-120);
				}
				// elseif (isset($_COOKIE["signup"])) 
				// {
				// 	if($_COOKIE["signup"]=="1")
				// 	{echo "<h3>Successful. You can login now</h3>";}
				// 	setcookie("signup", "0", time()-120);
				// }
				elseif (isset($_COOKIE["delete"])) 
				{
					if($_COOKIE["delete"]=="1")
					{echo "<h3>Account deleted</h3>";}
					setcookie("delete", "0", time()-120);
				}

				?>
				<div class="group">
				<input type="submit" name="signin" class="button" value="Login">
				</div>
				<div class="hr"></div>
		</form>
			</div>
			<div class="sign-up-htm">
			<h3 style='color:black;'>Signup</h3>
			<form action="./createlogin.php" method="POST">
				<div class="group">
					<input name="user" type="text" pattern="[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})" class="input" placeholder="Enter Email" required = "required">
				</div>
				<div class="group">
					<input name="name" type="text" class="input" placeholder="Enter Name" required = "required">
				</div>
				<div class="group">
					<input name="pass" type="password" pattern="[\S+]{6,120}" class="input" data-type="password" placeholder="Enter Password" required = "required">
				</div>
				<div class="group">
					<input name="pass1" type="password"  class="input" data-type="password" placeholder="Re-Enter Password" required = "required">
				</div><br>

				<div class="group">
					<input type="submit" name="signup" class="button" value="Sign Up">
					<br>
					<br>
				</div>
			</form>
				<div class="foot-lnk" style='color:blue;' >
					<label for="tab-1">Already registered? Login!</a>
				</div>
			</div>
		</div>
	</div>
</div>
  
  
</body>
</html>
