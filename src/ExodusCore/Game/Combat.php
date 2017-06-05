<?php
namespace ExodusCore\Game;
use ExodusCore\Interfaces\ClientInterface;
class Combat extends ClientInterface
{
    function doRound()
    {
        $target = null;

        if(!is_null($this->ch->FIGHTING_MOB)) {
            $target = $this->getGame()->getWorld()->getRoom($this->ch->data()->in_room)->mobiles[$this->ch->FIGHTING_MOB];
        }
    }
}