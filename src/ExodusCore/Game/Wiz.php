<?php
namespace ExodusCore\Game;
use ExodusCore\Interfaces\ClientInterface;
use ExodusCore\Interfaces\PlayerInterface;


class Wiz extends ClientInterface
{
    function grantExperience()
    {
        $arg_array = explode(" ", $this->args);

        if(count($arg_array) !== 2) {
            $this->ch->send("Syntax: grantxp [name] [amount]");
            return;
        }

        $ch_name = $arg_array[0];
        $target = null;

        /* @var $player PlayerInterface */
        foreach($this->getGame()->players as $player) {
            print_r($player->data());
            if($player->data()->name == $ch_name) {
                $target = $player;
            }
        }

        if(!is_null($target)) {
            $update = new Update();
            $update->gainExperience($target, $arg_array[1]);
        } else {
            $this->ch->send("I don't see them here.");
        }
    }
}