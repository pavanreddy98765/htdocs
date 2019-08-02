<?php

date_default_timezone_set("Asia/Kolkata");
function connect_to_db()
{
$host = "localhost";
$username = "root";
$password = "";
$database = "whatsapp";
$con = mysqli_connect("$host", "$username", "$password", "$database") or die ("cannot connect");
return $con;
}

?>