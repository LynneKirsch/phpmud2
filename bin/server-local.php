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
        $this->game = $game;
	}

    public function onOpen(ConnectionInterface $client)
    {
        $this->game->connect($client);
    }

    public function onMessage(ConnectionInterface $client, $args)
    {
        $this->game->dispatchCommand($client, $args);
    }

    public function onClose(ConnectionInterface $client)
    {
        $client->send("Connection closed.");
    }

    public function onError(ConnectionInterface $conn, \Exception $e) 
    {
        echo "An error has occurred: {$e->getMessage()}\n";
        $conn->close();
    }

}

$loop = LoopFactory::create();

$server = new IoServer(
    new HttpServer(
        new WsServer(
            new Server($loop, new GameInterface($loop))
        )
    ), new Reactor('127.0.0.1:9000', $loop), $loop);

$server->run();