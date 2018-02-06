<?php
/**
 * Created by PhpStorm.
 * User: lkirsch
 * Date: 2/6/2018
 * Time: 10:12 AM
 */

namespace ExodusCore\Interfaces;


use Ratchet\ConnectionInterface;

class GameInterface
{
    public function connect(ConnectionInterface $client)
    {
        $client->send("Who dares storm our wayward path?");
    }

}