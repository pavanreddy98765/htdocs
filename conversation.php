<?php
require 'global_vars.php';
$con = connect_to_db();

if(!isset($_COOKIE["username"]) || ($_COOKIE["username"]=='0'))
   {header("location:index.php");}
?>
<?php
$session = mt_rand(1,999);
?>
<!DOCTYPE html>
<html lang="en-US">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width" />
      <title>Conversation</title>
      <link rel="stylesheet" href="home_css/home_components.css">
      <link rel="stylesheet" href="home_css/home_responsee.css">
      <link rel="stylesheet" href="home_css/home_template-style.css">
      <link rel="stylesheet" href="home_css/home_table.css">
      <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
      <style>
        #chat_input {background-color:white;position:absolute;bottom:0;left:0;padding:10px;width:80%;height:43px;border:1px solid black;}
        #send{background-color:white;position:absolute;bottom:0;right:0;padding:10px;width:20%;height:43px;border:1px solid black;}
      </style>
   </head>
   
   <?php
   session_start();
   $_SESSION["username"]=$_COOKIE["username"];
   $username = $_SESSION["username"];
   $uid=$_GET['varname'];
   $_SESSION["user2"] = $uid;
	setcookie("user2",'$uid',time() + (86400 * 30));
   $result= mysqli_query($con,"select name as ename from user WHERE user_name = '$uid'") or die('Failed');
    while($row = mysqli_fetch_assoc($result))
    {
        $uname= $row['ename'];    
    }
   ?>
   <body >
   <div class="logo">
        <img src="logo.png" alt="logo" width="100%" height="auto">
   </div>
         </body>
</html>
<script src="http://code.jquery.com/jquery-latest.js"></script>
<script src="jquery.js"></script>
<script type="text/javascript">
  </script>
  
         <div id="message-box"class="message-box"  >
             <?php
             $result1= mysqli_query($con,"select * from messages WHERE (user1 = '$username'and user2='$uid') or (user2 = '$username'and user1='$uid')") or die('Failed');
             $x=0;
             $y=0;
            while($row1 = mysqli_fetch_assoc($result1))
            {
                $x=$x+1;
                $message= $row1['message'];
                $sent= $row1['user_sent'];
                $user1=$row1['user1'];
                $user2=$row1['user2'];
                $mydatetime=$row1['time'];
                $datetimearray = explode(" ", $mydatetime);
                $date = $datetimearray[0];
                $time = $datetimearray[1];
                $reformatted_date = date('d/m/Y',strtotime($date));
                $reformatted_time = date('h:i A',strtotime($time));


                if($user1==$username){
                    echo "<div id=$x class='ex2'>
                    <p>
                    $message
                    </p>
                    </div>
                    <br />";
                    $y=$x+100;
                    echo "<p id=$y></p>
                    <script>
                    //document.getElementById('demo').innerHTML=10;
                    var result = $('#$x').height();
                    result=result-21.4;
                    var str='';
                    while(result>1){
                        str+='<br />';
                        result=result-21.5;
                    }
                    document.getElementById($y).innerHTML=str;
                    </script>
                    ";   
                    echo "<br />";

                    echo "<div class='ex3'>";
                    echo $reformatted_time;
                    echo " ";
                    echo $reformatted_date;
                    echo "</div>" ;
                    echo "<br />";
                }
                else if($user1==$uid){
                    echo "<div id=$x class='ex1'>
                    <p>
                    $message
                    </p>
                    </div>
                    <br />";
                    $y=$x+100;
                    echo "<p id=$y></p>
                    <script>
                    //document.getElementById('demo').innerHTML=10;
                    var result = $('#$x').height();
                    result=result-21.4;
                    var str='';
                    while(result>1){
                        str+='<br />';
                        result=result-21.5;
                    }
                    document.getElementById($y).innerHTML=str;
                    </script>
                    ";                   
                    echo "<br />";
                    echo "<div class='ex4'>";
                    echo $reformatted_time;
                    echo " ";
                    echo $reformatted_date;
                    echo "</div>" ;
                    echo "<br />";
                }
            }
             ?>
             </div>
             
             <script type="text/javascript">
            var objDiv = document.getElementById("message-box");
            objDiv.scrollTop = objDiv.scrollHeight;
            </script>
            <textarea id="chat_input" placeholder=""></textarea>
		<button id="send" name="send-message">Send</button>
<script type="text/javascript">
		jQuery(function($){
			// Websocket
			var websocket_server = new WebSocket("ws://localhost:8080/");
			websocket_server.onopen = function(e) {
				websocket_server.send(
					JSON.stringify({
						'type':'socket',
						'user_id':<?php echo $session; ?>
					})
				);
			};
			websocket_server.onerror = function(e) {
				// Errorhandling
			}
			websocket_server.onmessage = function(e)
			{
				var json = JSON.parse(e.data);
                var str="";
                if((json.user1=="<?php echo $username; ?>")&&(json.user2=="<?php echo $uid; ?>")){
                var k=<?php $x=$x+1; echo $x;?>;
                str+="<div id=<?php echo $x; ?> class='ex2'><p>";
                str+=json.message;
                str+="</p></div><br /><br /><p id=<?php $y= $x+100; echo $y; ?>></p>";
                var str_time="";
                str_time +=  "<div class='ex3'>"
                    str_time+= json.time;
                    str_time+= " ";
                    str_time+= json.date;
                    str_time+= "</div><br />";
				switch(json.type){ 
					case 'chat':
                        $('#message-box').append(str);
                        str="";
                        var result = $('#<?php echo $x; ?>').height();
                    result=result-21.4;
                    var line='';
                    while(result>1){
                        str+='<br />';
                        result=result-21.5;
                    }
                    $('#message-box').append(str);
                    $('#message-box').append(str_time);
                        var objDiv = document.getElementById("message-box");
                        objDiv.scrollTop = objDiv.scrollHeight;
						break;
				}
            }
            else if((json.user2=="<?php echo $username; ?>")&&(json.user1=="<?php echo $uid; ?>")){
                str+="<div id=<?php echo $x; $x++; ?> class='ex1'><p>";
                str+=json.message;
                str+="</p></div><br /><br />";
				var str_time="";
                str_time +=  "<div class='ex4'>"
                    str_time+= json.time;
                    str_time+= " ";
                    str_time+= json.date;
                    str_time+= "</div><br />";
				switch(json.type){ 
					case 'chat':
                        $('#message-box').append(str);
                        $('#message-box').append(str_time);
                        var objDiv = document.getElementById("message-box");
                        objDiv.scrollTop = objDiv.scrollHeight;
						break;
				}
            }
			}
            // Events
            $("#send").click(function(){
                var chat_msg = $('#chat_input').val();
                    var value = '<?php echo $uname; ?>'; 
                    if(chat_msg!="") {
					websocket_server.send(
						JSON.stringify({
							'type':'chat',
                            'user_id':<?php echo $session; ?>,
                            'user1':'<?php echo $username; ?>',
                            'user2':'<?php echo $uid; ?>',
                            'chat_msg':chat_msg,
							'user_name': value
						})
                    );
                }
					$('#chat_input').val('');
            });
			$('#chat_input').on('keyup',function(e){
				if(e.keyCode==13 && !e.shiftKey)
				{ 
					var chat_msg = $('#chat_input').val();
                    var value = '<?php echo $uname; ?>';
                    if(chat_msg.length!=1) {
					websocket_server.send(
						JSON.stringify({
							'type':'chat',
                            'user_id':<?php echo $session; ?>,
                            'user1':'<?php echo $username; ?>',
                            'user2':'<?php echo $uid; ?>',
                            'chat_msg':chat_msg,
							'user_name': value
						})
                    );
                }
					$(this).val('');
				}
            });
            
		});
		</script>
        
		

