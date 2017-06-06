<?php
namespace ExodusCore\Objects;
class Room
{
    public $chars;
    public $data;
    public $items;

    public function __construct(\ExodusCore\Model\Rooms $room)
    {
        $this->data = $room;
    }

    public function attachMobile(\ExodusCore\Objects\Mobile $mob)
    {
        $this->chars[] = $mob;
    }

    public function attachChar(\ExodusCore\Objects\Char $player)
    {
        $this->chars[] = $player;
    }

    public function data():\ActiveRecord\Model
    {
        return $this->data;
    }
}