<?php
namespace ExodusCore\Game;
use ExodusCore\Interfaces\ClientInterface;

class Combat extends ClientInterface
{
    function doKill()
    {
        $room = $this->getGame()->getWorld()->getRoom($this->ch->data()->in_room);

    }
}