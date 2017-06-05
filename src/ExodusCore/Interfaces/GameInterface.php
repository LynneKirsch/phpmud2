<?php
namespace ExodusCore\Interfaces;
use ExodusCore\Objects\World;
use React\EventLoop\LoopInterface;
use Ratchet\ConnectionInterface;
use ExodusCore\Game\Login;
use ExodusCore\Game\Update;
use ExodusCore\Utility\Interpret;

class GameInterface
{
    public $update;
    public $loop;
    public $players;
    public $weather;
    public $world;

    public function start(LoopInterface $loop)
    {
        $this->setLoop($loop);

        $this->update = new Update();
        $this->update->start();

        $this->world = new World();
    }

    public function interpret(\ExodusCore\Objects\Player $ch, $args)
    {
        $interpreter = new Interpret($ch, $args);

        if ($ch->conn_state == 'CONNECTED') {
            $interpreter->interpret();
        } else {
            $login = new Login($ch, $args);
            $login->{$ch->conn_state}();
        }
    }

    public function connect($client)
    {
        $ch = new \ExodusCore\Objects\Player($client);
        $this->attachPlayer($ch);
        $ch->send("Who dares storm our wayward path?");
    }

    public function attachPlayer(\ExodusCore\Objects\Player $player)
    {
        $this->players[$player->client->resourceId] = $player;
    }

    public function disconnect(ConnectionInterface $client)
    {
        unset($this->players[$client->resourceId]);
        $client->send('The music in my heart I bore long after it was heard no more.');
        $client->close();
    }

    public function getLoop():LoopInterface
    {
        return $this->loop;
    }

    public function setLoop(LoopInterface $loop)
    {
        $this->loop = $loop;
    }

    public function getWorld():World
    {
        return $this->world;
    }


}