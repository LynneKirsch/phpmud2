<?php
namespace ExodusCore\Game;
use ExodusCore\Interfaces\ClientInterface;
use ExodusCore\Model\Player;
use ExodusCore\Model\WorldMobiles;

class Mage extends ClientInterface
{
    function doFireball()
    {
        $player = Player::first(['conditions' => ['name = ? and in_room = ?' => $this->args, $this->ch->data()->in_room]]);
        $mobile = WorldMobiles::first(['conditions' => ['name = ? and in_room = ?' => $this->args, $this->ch->data()->in_room]]);

        if(!empty($player)) {

        }
    }
}