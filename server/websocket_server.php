<?php
set_time_limit(0);
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
require_once '../vendor/autoload.php';

class Chat implements MessageComponentInterface {
	protected $clients;
	protected $users;

	public function __construct() {
		$this->clients = new \SplObjectStorage;
	}

	public function onOpen(ConnectionInterface $conn) {
		$this->clients->attach($conn);
		//$this->clients[$conn->resourceId] = $conn;
		 $this->users[$conn->resourceId] = "";
	}

	public function onClose(ConnectionInterface $conn) {
		$this->clients->detach($conn);
		// unset($this->users[$conn->resourceId]);
	}

	public function onMessage(ConnectionInterface $from,  $data) {

		$from_id = $from->resourceId;
		$data = json_decode($data);
		$type = $data->type;
		switch ($type) {
			case 'chat':
			{
			$host = "localhost";
			$username = "root";
			$password = "";
			$database = "whatsapp";
			$con = mysqli_connect("$host", "$username", "$password", "$database");
				$user_id = $data->user_id;
				$chat_msg = $data->chat_msg;
				$user1 = $data->user1;
				$user2 = $data->user2;
				$str=$chat_msg;
				$x=1;
				$ver = mysqli_query($con,"Insert into messages Values('$user1','$user2','$chat_msg','$x',CURRENT_TIME())");
				$result1= mysqli_query($con,"select * from messages WHERE (user1 = '$user1'and user2='$user2') order by time desc limit 1") or die('Failed');
				$mydatetime;
				while($row1 = mysqli_fetch_assoc($result1)){
				$mydatetime = $row1['time'];
				}
                $datetimearray = explode(" ", $mydatetime);
                $date = $datetimearray[0];
                $time = $datetimearray[1];
                $reformatted_date = date('d/m/Y',strtotime($date));
                $reformatted_time = date('h:i A',strtotime($time));
				$response_from = "<span style='color:#999'><b>".$from_id.":</b> ".$chat_msg."</span><br><br>";
				$response_to = "<b>".$time."</b>: ".$str."<br><br>";
				// Output
				$from->send(json_encode(array("type"=>$type,"msg"=>$response_from,"message"=>$str,"user1"=>$user1,"user2"=>$user2,"date"=>$reformatted_date,"time"=>$reformatted_time)));
				foreach($this->clients as $client)
				{
					
					if($from!=$client)
					{
						if($this->users[$client->resourceId]==$user2||$this->users[$client->resourceId]==$user1){
						$client->send(json_encode(array("type"=>$type,"msg"=>$response_to,"message"=>$str,"user1"=>$user1,"user2"=>$user2,"date"=>$reformatted_date,"time"=>$reformatted_time)));
						}
					}

				}
				break;
			}
			case 'socket':
			{
			$this->users[$from->resourceId]=$data->user_id;
			break;
			}
		}
	}

	public function onError(ConnectionInterface $conn, \Exception $e) {
		$conn->close();
	}
}
$server = IoServer::factory(
	new HttpServer(new WsServer(new Chat())),
	8080
);
$server->run();
?>
