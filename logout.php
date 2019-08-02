<?php
require 'global_vars.php';
$con = connect_to_db();
setcookie("username",'0',time() - (86400 * 30));
setcookie("time",'0',time() - (86400 * 30));
session_destroy();
header("location: index.php");
?>