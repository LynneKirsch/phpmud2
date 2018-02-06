<?php 
require '../vendor/autoload.php';
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use React\Socket\Server as Reactor;
use React\EventLoop\Factory as LoopFactory;
use ExodusCore\Interfaces\GameInterface;

class Server implements MessageComponentInterface
{
    public $game;

    public function __construct(React\EventLoop\LoopInterface $loop, GameInterface $game)
    {
        $cfg = ActiveRecord\Config::instance();
        $cfg->set_model_directory('../src/ExodusCore/Model');
        $cfg->set_connections(array('development' => 'sqlite://../bin/exodus.db'));
        $this->game = $game;
	}

    public function onOpen(ConnectionInterface $client)
    {
        $this->game->connect($client);
    }

    public function onMessage(ConnectionInterface $client, $args)
    {
        $client->send("ok");
    }

    public function onClose(ConnectionInterface $client)
    {

    }

    public function onError(ConnectionInterface $conn, \Exception $e) 
    {
        echo "An error has occurred: {$e->getMessage()}\n";
        $conn->close();
    }

}

$game = new GameInterface();
$loop = LoopFactory::create();
$socket = new Reactor($loop);
$socket->listen(9000, 'localhost');
$server = new IoServer(
    new HttpServer(
        new WsServer(
            new Server($loop, $game)
        )
    ), $socket, $loop);
$server->run();