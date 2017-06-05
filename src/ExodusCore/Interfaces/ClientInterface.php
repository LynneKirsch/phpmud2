<?php
namespace ExodusCore\Interfaces;
use ExodusCore\Utility\UI;

class ClientInterface
{
    public $ch;
    public $args;
    public $game;
    public $ui;

    function __construct(\ExodusCore\Objects\Player $ch = null, $args = null)
    {
        /*
         * I hate this. But I can't think of a better way to get the game/world information
         * to all the base game classes. I really hope I don't end up having to refactor this.
         * But what's one measly global variable? FAMOUS LAST WORDS.
         */
        global $game;

        $this->ch = $ch;
        $this->args = $args;
        $this->game = $game;
        $this->ui = new UI();
    }

    function getGame():GameInterface
    {
        return $this->game;
    }

    function getUI():UI
    {
        return $this->ui;
    }

    function getChar():\ExodusCore\Objects\Player
    {
        return $this->ch;
    }

    function toChar(\ExodusCore\Objects\Player $player, $payload)
    {
        $player->send($payload);
    }

    function getTarget($name)
    {
        /* @var $player \ExodusCore\Objects\Player */
        foreach($this->getGame()->players as $player) {
            if($player->data()->name == $name) {
                return $player;
            }
        }

        return null;
    }

    function toGlobal($payload)
    {
        /* @var $player \ExodusCore\Objects\Player */
        foreach($this->getGame()->players as $player) {
            $player->send($payload);
        }
    }

    function toOthersGlobal($payload)
    {
        /* @var $player \ExodusCore\Objects\Player */
        foreach($this->getGame()->players as $player) {
           if($player->client != $this->ch->client) {
               $player->send($payload);
           }
        }
    }

    function getArgs():string
    {
        return $this->args;
    }

}