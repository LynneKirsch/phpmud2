<?php
namespace ExodusCore\Objects;
class Mobile
{
    public function __construct(\ActiveRecord\Model $mobile, $room_id)
    {
        $this->id = $mobile->id;
        $this->name = $mobile->name;
        $this->description = $mobile->description;
        $this->hp = $mobile->hp;
        $this->in_room = $room_id;
    }

    public function spawn()
    {
        global $game;
        $room = $game->getWorld()->getRoom($this->in_room);
        $room->attachMobile($this);
    }
}