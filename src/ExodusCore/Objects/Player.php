<?php
/**
 * Created by PhpStorm.
 * User: lkirsch
 * Date: 2/7/2018
 * Time: 9:47 AM
 */

namespace ExodusCore\Objects;


use Ratchet\ConnectionInterface;

class Client
{
    private $client;
    private $character;

    /**
     * @return mixed
     */
    public function getClient(): ConnectionInterface
    {
        return $this->client;
    }

    /**
     * @param mixed $client
     */
    public function setClient(ConnectionInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @return mixed
     */
    public function getCharacter()
    {
        return $this->character;
    }

    /**
     * @param mixed $character
     */
    public function setCharacter($character)
    {
        $this->character = $character;
    }


}