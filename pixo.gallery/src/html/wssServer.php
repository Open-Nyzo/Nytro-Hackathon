<?php require 'vendor/autoload.php';

use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

require 'inc/config.inc.php';
require 'inc/pixo.class.php';


define('APP_PORT', 8880);

/* Apache proxy:
 <Location "/wss/board">
    ProxyPass ws://localhost:8880
    ProxyPassReverse ws://localhost:8880
  </Location>
*/

class ServerImpl implements MessageComponentInterface {
    protected $clients;
    protected $db;
    public $pixo;
    public $last_height;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
        global $DB;
        $this->db = $DB;
        global $CONFIG;
        $this->pixo = new Pixo($CONFIG);
        $this->current_user_count = 0;
        $this->last_height = $this->pixo->getLastHeight();
    }
    
   
    public function onOpen(ConnectionInterface $conn) {
        $this->clients->attach($conn);
        $this->current_user_count ++;
        echo "New connection! ({$conn->resourceId}).\n";
        
    }

    public function onMessage(ConnectionInterface $conn, $msg) {
        echo sprintf("New message from '%s': %s\n\n\n", $conn->resourceId, $msg);
        $message = json_decode($msg, true);
        $methodName = "on".$message["Action"];
        if (method_exists($this, $methodName)) {
            $this->$methodName($conn, $message["Data"]);
        } else {
            error_log("Unknown ws method: ".$methodName);
        }
    }

    public function sendEventAll($event, $data, $board=false, $except=null) {
        $msg=json_encode(array("Event" => $event, "Data"=> $data));
        foreach ($this->clients as $client) { // BROADCAST
            if ($except !== $client) {
                if($board === false or $client->board == $board){
                    $client->send($msg);
                }
            }
        }
    }

    private function Register($conn) {
        $board = $this->pixo->getBoard($board=$conn->board);

        $msg=array("Event" => "Init", "Data"=> $board);
        $conn->send(json_encode($msg));

        $msg=json_encode(array("Event" => "GlobalCloseness", "Data"=> $this->pixo->globalScore()));
        $conn->send($msg);
        
        $this->sendEventAll("UserCount", $this->current_user_count);
        
    }
    
    private function onRegister($conn, $data) {
         error_log("onRegister ".$data);
         $conn->board = $this->pixo->getBoardName($data);
         $this->Register($conn);
    }

    public function onClose(ConnectionInterface $conn) {
        $this->clients->detach($conn);
        $this->current_user_count --;
        echo "Connection {$conn->resourceId} is gone.\n";
        $this->sendEventAll("UserCount", $this->current_user_count);
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error occured on connection {$conn->resourceId}: {$e->getMessage()}\n\n\n";
        $conn->close();
    }
}

$serverimpl = new ServerImpl();

$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            $serverimpl
        )
    ),
    APP_PORT
);

$server->loop->addPeriodicTimer(5, function () use ($serverimpl) {  
    global $CONFIG;
    foreach($CONFIG["boards"] as $board){
        $txs = $serverimpl->pixo->getPixelsAfter($serverimpl->last_height, $board);
        foreach($txs as $pixel){
            $msg=array("id" => $pixel["pixel"], "color" => $pixel["color"], "address"=>$pixel["address"]);
            $serverimpl->last_height = $pixel["height"];
            $serverimpl->sendEventAll("Paint", $msg, $board);
        }
    }    
    
});


echo "Server created on port " . APP_PORT . "\n\n";
$server->run();
